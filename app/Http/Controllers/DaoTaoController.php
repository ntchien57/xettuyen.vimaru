<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DaoTaoController extends Controller
{
    public function index()
    {
        return view('daotao.home');
    }

    public function xettuyen()
    {
        $thiSinhs = json_decode(Storage::get('dulieu_thisinh.json'), true);

        return view('daotao.xettuyen', compact('thiSinhs'));
    }

    public function chayXetTuyen(Request $request)
    {
        $thiSinhs = json_decode(Storage::get('dulieu_thisinh.json'), true);

        // Thêm các trường cần thiết
        foreach ($thiSinhs as &$ts) {
            $ts['trang_thai'] = 'dang_xet';
            $ts['index_nv'] = 0;
        }

        $quotas = $request->input('quota');
        $nganhs = [];
        foreach ($quotas as $key => $value) {
            $nganhs[$key] = ['quota' => (int)$value, 'tam_nhan' => [], 'ds_moi' => []];
        }
        // Thuật toán DAA
        $co_thay_doi = true;
        while ($co_thay_doi) {
            $co_thay_doi = false;
            $ung_vien_moi = [];

            foreach ($thiSinhs as &$ts) {
                if ($ts['trang_thai'] !== 'dang_xet') continue;

                $nv = $ts['nguyen_vongs'][$ts['index_nv']] ?? null;
                if (!$nv) {
                    $ts['trang_thai'] = 'rot';
                    continue;
                }

                $ung_vien_moi[$nv][] = &$ts;
            }

            foreach ($ung_vien_moi as $nganh => $ds) {
                $cu = $nganhs[$nganh]['tam_nhan'];
                $tap_hop = array_merge($cu, $ds);

                usort($tap_hop, fn($a, $b) => $b['diem'] <=> $a['diem']);
                $moi = array_slice($tap_hop, 0, $nganhs[$nganh]['quota']);

                $ids_cu = array_column($cu, 'id');
                $ids_moi = array_column($moi, 'id');

                if ($ids_cu !== $ids_moi) $co_thay_doi = true;

                $nganhs[$nganh]['tam_nhan'] = $moi;

                foreach ($tap_hop as &$ts) {
                    if (in_array($ts['id'], $ids_moi)) {
                        $ts['trang_thai'] = 'trung_tuyen';
                    } else {
                        $ts['index_nv']++;
                        if (!isset($ts['nguyen_vongs'][$ts['index_nv']])) {
                            $ts['trang_thai'] = 'rot';
                        } else {
                            $ts['trang_thai'] = 'dang_xet';
                        }
                    }
                }
            }
        }

        return view('daotao.xettuyen', [
            'thiSinhs' => $thiSinhs,
            'daXetTuyen' => true
        ]);
    }

    public function ketquaxettuyen(Request $request){
        $q      = trim($request->input('q', ''));
        $major  = $request->input('major'); // code ngành
        $sort   = strtolower($request->input('sort', 'desc')); // 'asc' | 'desc'
        $sort   = in_array($sort, ['asc','desc'], true) ? $sort : 'desc';
        $perPage = 20;

        // Dropdown ngành để lọc
        $majors = DB::table('majors')
            ->select('code','name')
            ->where('active',1)
            ->orderBy('code')
            ->get();

        // Danh sách trúng tuyển
        $wishes = DB::table('wishes as w')
            ->join('users as u', 'u.id', '=', 'w.user_id')
            ->leftJoin('majors as m', 'm.code', '=', 'w.major_code')
            ->leftJoin('combo_offsets as co', function ($j) {
                $j->on('co.combo_code', '=', 'w.exam_combo')
                  ->where('co.base_code', 'D01')
                  ->where('co.active', 1);
            })
            ->where('w.status', 'accepted')
            ->when($major, fn($qr) => $qr->where('w.major_code', $major))
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('u.hoten', 'like', "%{$q}%")
                        ->orWhere('u.email', 'like', "%{$q}%")
                        ->orWhere('u.cccd', 'like', "%{$q}%");
                });
            })
            ->select([
                'w.id',
                'w.user_id',
                'w.exam_id',
                'w.major_code',
                'w.order_no',
                'w.converted_score',
                'w.raw_score',
                'w.exam_combo',
                'w.updated_at', // dùng làm thời điểm đậu
                'u.hoten as student_name',
                'u.email',
                'u.cccd',
                'm.name as major_name',
                // Điểm quy đổi D01 tính động nếu thiếu converted_score
                DB::raw('COALESCE(w.converted_score, w.raw_score + COALESCE(co.delta,0)) as score_d01'),
            ])
            ->orderBy('score_d01', $sort)
            ->orderBy('w.order_no')      // NV nhỏ ưu tiên hơn nếu điểm bằng
            ->orderBy('w.user_id')       // ổn định
            ->paginate($perPage);

        return view('daotao.result', compact('wishes','majors','major','q','sort'));
    }
}
