<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use App\Exports\AcceptedWishesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WishController extends Controller
{
    public function index(Request $request)
    {
        // (optional) bộ lọc nhanh theo tên/email/cccd
        $q = trim($request->input('q', ''));

        $wishes = Wish::query()
            ->with([
                'user:id,hoten,email,cccd',
                'major:code,name'
            ])
            ->when($q !== '', function ($qr) use ($q) {
                $qr->whereHas('user', function ($u) use ($q) {
                    $u->where('hoten', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('cccd', 'like', "%{$q}%");
                });
            })
            ->orderBy('user_id')
            ->orderBy('order_no')
            ->paginate(20)
            ->withQueryString();

        return view('admin.wishes.index', compact('wishes', 'q'));
    }

    public function runQuota(Request $request)
    {
        $tieMode = strtolower($request->input('tie', 'strict')); // strict | overflow
        if (!in_array($tieMode, ['strict', 'overflow'], true)) $tieMode = 'strict';

        // 1) Lấy majors có quota > 0
        $majors = DB::table('majors')
            ->select('code as major_code', 'name as major_name', 'quota', 'cutoff_score')
            ->where('active', 1)
            ->where('quota', '>', 0)
            ->orderBy('code')
            ->get();

        if ($majors->isEmpty()) {
            return back()->with('error', 'Không có chuyên ngành nào có chỉ tiêu > 0.');
        }

        $quota = $majors->mapWithKeys(fn($m) => [$m->major_code => (int) $m->quota])->all();

        // (Tuỳ chọn) tie_policy theo ngành: nếu bạn có cột tie_policy trong majors, map vào đây
        $tiePolicyByMajor = [];
        foreach ($majors as $m) {
            $tiePolicyByMajor[$m->major_code] = $tieMode; // hoặc lấy từ $m->tie_policy nếu có
        }

        // 2) Map độ chênh nếu cần tự tính (chưa dùng nếu đã có converted_score sẵn)
        $deltaMap = DB::table('combo_offsets')
            ->where('base_code', 'D01')
            ->where('active', 1)
            ->pluck('delta', 'combo_code')
            ->map(fn($v) => (float) $v)
            ->all();

        // 3) Lấy dữ liệu nguyện vọng (mọi thí sinh)
        //    Yêu cầu cột: wishes.id, user_id, major_code, order_no, converted_score (ưu tiên),
        //                 nếu không có converted_score thì có thể dùng raw_score + exam_combo để tự tính.
        $apps = DB::table('wishes as w')
            ->join('users as u', 'u.id', '=', 'w.user_id')
            ->leftJoin('majors as m', 'm.code', '=', 'w.major_code')
            ->whereIn('w.major_code', array_keys($quota))
            ->select([
                'w.id',
                'w.user_id as student_id',
                'u.hoten as student_name',
                'w.major_code',
                'w.order_no as pref_rank',
                'w.converted_score',
                'w.raw_score',
                'w.exam_combo',
            ])
            ->orderBy('w.user_id')
            ->orderBy('w.order_no')
            ->get();

        if ($apps->isEmpty()) {
            return back()->with('error', 'Không có dữ liệu nguyện vọng hợp lệ để xét.');
        }

        // 4) Chuẩn hoá dữ liệu điểm:
        //    - score_line = converted_score (nếu có) ; nếu không có mà có raw_score + exam_combo, tự tính: converted = raw + delta(combo)
        $rows = [];
        foreach ($apps as $r) {
            $scoreLine = null;

            if (!is_null($r->converted_score)) {
                $scoreLine = (float) $r->converted_score;
            } elseif (!is_null($r->raw_score) && $r->exam_combo) {
                $delta = $deltaMap[$r->exam_combo] ?? null;
                if (!is_null($delta)) {
                    $scoreLine = (float) $r->raw_score + (float) $delta;
                }
            }

            $rows[] = [
                'id'        => (int) $r->id,
                'student_id' => (int) $r->student_id,
                'student_name' => $r->student_name,
                'major_code' => $r->major_code,
                'pref_rank' => (int) $r->pref_rank,
                'score_line' => $scoreLine, // điểm dòng (đã quy về D01 nếu có)
                'score_raw' => is_null($r->raw_score) ? $scoreLine : (float) $r->raw_score, // tie-break phụ
            ];
        }

        // 5) Gắn "điểm D01 cao nhất theo thí sinh" (global)
        $byStudent = [];
        foreach ($rows as $i => $r) {
            $byStudent[$r['student_id']][] = $i;
        }
        $bestGlobal = [];
        foreach ($byStudent as $sid => $idxs) {
            $maxv = null;
            foreach ($idxs as $i) {
                $v = $rows[$i]['score_line'];
                if (is_null($v)) continue;
                if ($maxv === null || $v > $maxv) $maxv = $v;
            }
            $bestGlobal[$sid] = $maxv; // có thể null (nếu thí sinh không có điểm hợp lệ)
        }
        foreach ($rows as &$r) {
            $r['score_global'] = $bestGlobal[$r['student_id']];
        }
        unset($r);

        // 6) Deferred Acceptance theo quota, tie-policy
        $holds = [];
        foreach ($quota as $maj => $q) $holds[$maj] = [];
        $assigned = [];                         // student_id -> major_code tạm
        $nextChoiceIdx = [];
        foreach ($byStudent as $sid => $_) $nextChoiceIdx[$sid] = 0;

        // comparator
        $cmp = function ($ia, $ib) use (&$rows) {
            $a = $rows[$ia];
            $b = $rows[$ib];
            // 1) score_global ↓
            $ga = $a['score_global'];
            $gb = $b['score_global'];
            if ($ga !== $gb) return ($ga <=> $gb) * -1; // null sẽ đứng cuối
            // 2) score_raw/line ↓ (phụ; nếu không có raw_score, đã gán = score_line)
            $sa = $a['score_raw'];
            $sb = $b['score_raw'];
            if ($sa !== $sb) return ($sa <=> $sb) * -1;
            // 3) pref_rank ↑
            if ($a['pref_rank'] !== $b['pref_rank']) return ($a['pref_rank'] <=> $b['pref_rank']);
            // 4) student_id ↑
            if ($a['student_id'] !== $b['student_id']) return ($a['student_id'] <=> $b['student_id']);
            // 5) wish id ↑ (ổn định)
            return ($a['id'] <=> $b['id']);
        };

        $changed = true;
        while ($changed) {
            $changed = false;

            // Proposals by major
            $proposals = [];
            foreach ($quota as $maj => $_) $proposals[$maj] = [];

            // mỗi thí sinh chưa đậu → nộp NV kế tiếp hợp lệ (có score_global)
            foreach ($byStudent as $sid => $idxs) {
                if (isset($assigned[$sid])) continue;
                while ($nextChoiceIdx[$sid] < count($idxs)) {
                    $i = $idxs[$nextChoiceIdx[$sid]];
                    $nextChoiceIdx[$sid]++;

                    if (is_null($rows[$i]['score_global'])) {
                        // không có điểm hợp lệ → bỏ qua NV này và thử NV kế tiếp vòng sau
                        continue;
                    }
                    $maj = $rows[$i]['major_code'];
                    if (!isset($quota[$maj])) break; // ngành không tuyển/không có quota
                    $proposals[$maj][] = $i;
                    break;
                }
            }

            // mỗi ngành xét giữ theo quota + tie
            foreach ($quota as $maj => $q) {
                if (empty($proposals[$maj]) && empty($holds[$maj])) continue;

                $pool = array_merge($holds[$maj], $proposals[$maj]);
                usort($pool, $cmp); // sắp xếp ưu tiên

                // Chọn theo tie policy
                if ($q <= 0 || count($pool) <= $q || ($tiePolicyByMajor[$maj] ?? 'strict') !== 'overflow') {
                    $keep = array_slice($pool, 0, $q);
                    $drop = array_slice($pool, $q);
                } else {
                    $keep = array_slice($pool, 0, $q);
                    $drop = [];
                    if (!empty($keep)) {
                        $lastScore = $rows[end($keep)]['score_global'];
                        for ($idx = $q; $idx < count($pool); $idx++) {
                            $i = $pool[$idx];
                            $s = $rows[$i]['score_global'];
                            if ($s === $lastScore) $keep[] = $i;
                            else {
                                $drop = array_slice($pool, $idx);
                                break;
                            }
                        }
                    } else {
                        $drop = $pool;
                    }
                }

                if (implode(',', $holds[$maj]) !== implode(',', $keep)) {
                    $holds[$maj] = $keep;
                    $changed = true;
                }
            }

            // cập nhật assigned tạm thời
            $assigned = [];
            foreach ($holds as $maj => $list) {
                foreach ($list as $i) $assigned[$rows[$i]['student_id']] = $maj;
            }
        }

        // 7) Kết quả: mỗi phần tử giữ chỗ trong holds là 1 NV trúng tuyển
        $acceptedWishIds = [];
        $acceptedByMajor = [];
        foreach ($holds as $maj => $list) {
            foreach ($list as $i) {
                $acceptedWishIds[] = $rows[$i]['id'];
                $acceptedByMajor[$maj] = ($acceptedByMajor[$maj] ?? 0) + 1;
            }
        }

        // 8) Ghi DB: tất cả NV của các thí sinh có trong phiên xét này → reset 'rejected', rồi set 'accepted' cho wish trúng
        $studentIds = array_keys($byStudent);

        DB::transaction(function () use ($studentIds, $acceptedWishIds) {
            // đưa tất cả NV của các thí sinh về 'rejected' trước
            DB::table('wishes')->whereIn('user_id', $studentIds)->update(['status' => 'rejected']);
            // set 'accepted' cho NV trúng
            if (!empty($acceptedWishIds)) {
                DB::table('wishes')->whereIn('id', $acceptedWishIds)->update(['status' => 'accepted']);
            }
        });

        // 9) Tổng kết
        $totalAccepted = count($acceptedWishIds);
        $sumMsg = "Đã xét tuyển: {$totalAccepted} nguyện vọng trúng. ";
        if ($acceptedByMajor) {
            $parts = [];
            foreach ($acceptedByMajor as $maj => $cnt) $parts[] = "$maj: $cnt";
            $sumMsg .= 'Phân bổ: ' . implode(' | ', $parts);
        }

        return back()->with('success', $sumMsg);
    }

    public function runCutoff(Request $request)
    {
        // unique per student (mặc định): 1 thí sinh chỉ đỗ 1 NV đầu tiên đạt cutoff
        $uniquePerStudent = !$request->boolean('multi', false);

        // 1) Lấy các ngành có điểm chuẩn
        $majors = DB::table('majors')
            ->select('code as major_code', 'name as major_name', 'cutoff_score')
            ->where('active', 1)
            ->whereNotNull('cutoff_score')
            ->orderBy('code')
            ->get();

        if ($majors->isEmpty()) {
            return back()->with('error', 'Chưa cấu hình điểm chuẩn cho bất kỳ chuyên ngành nào.');
        }

        $cutoff = $majors->pluck('cutoff_score', 'major_code')
            ->map(fn($v) => (float) $v)
            ->all();

        // 2) Bản đồ độ chênh (nếu cần quy đổi từ raw_score + combo → D01)
        $deltaMap = DB::table('combo_offsets')
            ->where('base_code', 'D01')
            ->where('active', 1)
            ->pluck('delta', 'combo_code')
            ->map(fn($v) => (float) $v)
            ->all();

        // 3) Lấy toàn bộ nguyện vọng thuộc các ngành có cutoff
        $apps = DB::table('wishes as w')
            ->join('users as u', 'u.id', '=', 'w.user_id')
            ->whereIn('w.major_code', array_keys($cutoff))
            ->select([
                'w.id',
                'w.user_id as student_id',
                'u.hoten as student_name',
                'w.major_code',
                'w.order_no as pref_rank',
                'w.converted_score',
                'w.raw_score',
                'w.exam_combo',
            ])
            ->orderBy('w.user_id')
            ->orderBy('w.order_no')
            ->get();

        if ($apps->isEmpty()) {
            return back()->with('error', 'Không có dữ liệu nguyện vọng hợp lệ để xét theo điểm chuẩn.');
        }

        // 4) Tính điểm D01 cho từng nguyện vọng (score_line)
        $rows = [];
        foreach ($apps as $r) {
            $scoreLine = null;
            if (!is_null($r->converted_score)) {
                $scoreLine = (float) $r->converted_score;
            } elseif (!is_null($r->raw_score) && $r->exam_combo) {
                $delta = $deltaMap[$r->exam_combo] ?? null;
                if (!is_null($delta)) {
                    $scoreLine = (float) $r->raw_score + (float) $delta;
                }
            }

            $rows[] = [
                'id'          => (int) $r->id,
                'student_id'  => (int) $r->student_id,
                'student_name' => $r->student_name,
                'major_code'  => $r->major_code,
                'pref_rank'   => (int) $r->pref_rank,
                'score_line'  => $scoreLine, // điểm quy đổi D01 của dòng (có thể null nếu không đủ dữ liệu)
            ];
        }

        // 5) Gom theo thí sinh
        $byStudent = [];
        foreach ($rows as $i => $r) {
            $byStudent[$r['student_id']][] = $i;
        }
        // Đảm bảo thứ tự NV tăng dần
        foreach ($byStudent as $sid => &$idxs) {
            usort($idxs, fn($a, $b) => $rows[$a]['pref_rank'] <=> $rows[$b]['pref_rank']);
        }
        unset($idxs);

        // 6) Xét theo cutoff
        $acceptedWishIds = [];
        $acceptedByMajor = [];

        if ($uniquePerStudent) {
            // Mỗi thí sinh: nhận NV đầu tiên đạt cutoff
            foreach ($byStudent as $sid => $idxs) {
                foreach ($idxs as $i) {
                    $maj = $rows[$i]['major_code'];
                    $s   = $rows[$i]['score_line'];
                    $cut = $cutoff[$maj] ?? null;
                    if (!is_null($s) && !is_null($cut) && $s >= $cut) {
                        $acceptedWishIds[] = $rows[$i]['id'];
                        $acceptedByMajor[$maj] = ($acceptedByMajor[$maj] ?? 0) + 1;
                        break; // chỉ nhận NV đầu tiên đạt cutoff
                    }
                }
            }
        } else {
            // Nhận TẤT CẢ các NV đạt cutoff (một thí sinh có thể đỗ nhiều ngành)
            foreach ($rows as $r) {
                $maj = $r['major_code'];
                $s   = $r['score_line'];
                $cut = $cutoff[$maj] ?? null;
                if (!is_null($s) && !is_null($cut) && $s >= $cut) {
                    $acceptedWishIds[] = $r['id'];
                    $acceptedByMajor[$maj] = ($acceptedByMajor[$maj] ?? 0) + 1;
                }
            }
        }

        // 7) Ghi DB
        if ($uniquePerStudent) {
            // Đưa toàn bộ NV của những thí sinh tham gia về 'rejected', rồi set 'accepted' cho NV đỗ
            $studentIds = array_keys($byStudent);
            DB::transaction(function () use ($studentIds, $acceptedWishIds) {
                DB::table('wishes')->whereIn('user_id', $studentIds)->update(['status' => 'rejected']);
                if (!empty($acceptedWishIds)) {
                    DB::table('wishes')->whereIn('id', $acceptedWishIds)->update(['status' => 'accepted']);
                }
            });
        } else {
            // Cho phép đỗ nhiều ngành: chỉ cập nhật hàng đỗ → accepted, không đụng các hàng khác
            if (!empty($acceptedWishIds)) {
                DB::table('wishes')->whereIn('id', $acceptedWishIds)->update(['status' => 'accepted']);
            }
        }

        // 8) Tổng kết
        $totalAccepted = count($acceptedWishIds);
        $sumMsg = "Xét theo điểm chuẩn: {$totalAccepted} nguyện vọng đỗ. ";
        if ($acceptedByMajor) {
            $parts = [];
            foreach ($acceptedByMajor as $maj => $cnt) $parts[] = "$maj: $cnt";
            $sumMsg .= 'Phân bổ: ' . implode(' | ', $parts);
        }

        return back()->with('success', $sumMsg);
    }

    public function exportAllAccepted(Request $request)
    {
        // mặc định sắp điểm cao → thấp; cho phép ?sort=asc nếu muốn
        $sort = strtolower($request->input('sort', 'desc'));
        $sort = in_array($sort, ['asc', 'desc'], true) ? $sort : 'desc';

        $builder = DB::table('wishes as w')
            ->join('users as u', 'u.id', '=', 'w.user_id')
            ->leftJoin('majors as m', 'm.code', '=', 'w.major_code')
            ->leftJoin('combo_offsets as co', function ($j) {
                $j->on('co.combo_code', '=', 'w.exam_combo')
                    ->where('co.base_code', 'D01')
                    ->where('co.active', 1);
            })
            ->where('w.status', 'accepted')
            ->select([
                'w.id',
                'w.user_id',
                'w.exam_id',
                'w.major_code',
                'w.order_no',
                'w.converted_score',
                'w.raw_score',
                'w.exam_combo',
                'w.updated_at',
                'u.hoten as student_name',
                'u.email',
                'u.cccd',
                'm.name as major_name',
                DB::raw('COALESCE(w.converted_score, w.raw_score + COALESCE(co.delta,0)) as score_d01'),
            ])
            ->orderBy('w.major_code')
            ->orderBy('score_d01', $sort)
            ->orderBy('w.order_no')
            ->orderBy('w.user_id');

        $filename = 'accepted_all_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new AcceptedWishesExport($builder), $filename);
    }

    
}
