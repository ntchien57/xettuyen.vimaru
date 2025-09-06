<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use App\Models\Major;
use App\Models\Profile;
use App\Models\ComboOffset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view("user.home");
    }
    public function profile()
    {
        $profile = Profile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                // mặc định rỗng lần đầu
                'email' => Auth::user()->email ?? null,
                'full_name' => Auth::user()->hoten ?? null,
                'cccd_number' => Auth::user()->cccd ?? null,
            ],


        );
        return view("user.profile", compact('profile'));
    }

    public function save(Request $request)
    {
        $userId = Auth::id();
        $profile = Profile::firstOrNew(['user_id' => $userId]);

        // Lấy dữ liệu input (whitelist field)
        $data = $request->only([
            // THÔNG TIN CHUNG
            'full_name',
            'dob',
            'gender',
            'ethnicity',
            'cccd_number',
            'birth_place',
            'email',
            'phone',
            'address',
            // TUYỂN SINH
            'priority_object',
            'priority_area',
            'graduation_year',
            // LIÊN HỆ
            'contact_name',
            'contact_relation',
            'contact_phone',
            'contact_email',
        ]);

        // Chuẩn hoá gender
        if (isset($data['gender']) && $data['gender'] !== '') {
            $map = ['0' => 'male', '1' => 'female', 'male' => 'male', 'female' => 'female'];
            $data['gender'] = $map[$data['gender']] ?? null;
        } else {
            $data['gender'] = null;
        }

        // Chuẩn hoá năm tốt nghiệp (tùy chọn)
        if (isset($data['graduation_year']) && $data['graduation_year'] !== '') {
            $data['graduation_year'] = (int) $data['graduation_year'];
        } else {
            $data['graduation_year'] = null;
        }

        $dir = public_path('upload/cccd/' . date('Y/m/d'));
        File::ensureDirectoryExists($dir);

        foreach (['cccd_front_path', 'cccd_back_path'] as $key) {
            /** @var UploadedFile|null $file */
            $file = $request->file($key);
            if ($file instanceof UploadedFile && $file->isValid()) {
                // Xoá cũ
                if (!empty($profile->$key)) {
                    @File::delete(public_path('upload/' . $profile->$key));
                }
                // Tên file
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

                // Di chuyển vào public/upload/...
                $file->move($dir, $filename);

                // Lưu DB: đường dẫn tương đối sau /upload
                $rel = 'cccd/' . date('Y/m/d') . '/' . $filename;
                $data[$key] = $rel;
            }
        }

        // Lưu DB
        $data['user_id'] = $userId;
        $profile->fill($data)->save();

        return back()->with('success', 'Đã lưu thông tin hồ sơ.');
    }

    public function registerWishes()
    {
        $majors = Major::where('active', true)
            ->orderBy('order_no')->orderBy('code')
            ->get(['code', 'name']);

        // danh sách code các NV đã lưu (nếu có)
        $wishes = Wish::where('user_id', auth()->id())
            ->orderBy('order_no')->pluck('major_code');

        $wishes1 = Wish::where('user_id', auth()->id())
            ->orderBy('order_no')->first();

        return view('user.register', compact('majors', 'wishes','wishes1'));
    }

    private array $comboLabels = [
        'D01' => 'Toán, Ngữ văn, Tiếng Anh',
        'A00' => 'Toán, Vật lí, Hóa học',
        'A01' => 'Toán, Vật lí, Tiếng Anh',
        'C00' => 'Ngữ văn, Lịch sử, Địa lí',
        'C01' => 'Ngữ văn, Toán, Vật lí',
        'C02' => 'Ngữ văn, Toán, Hóa học',
        'C03' => 'Ngữ văn, Toán, Lịch sử',
        'C04' => 'Ngữ văn, Toán, Địa lí',
        'D09' => 'Toán, Lịch sử, Tiếng Anh',
        'D10' => 'Toán, Địa lí, Tiếng Anh',
        'D14' => 'Ngữ văn, Lịch sử, Tiếng Anh',
        'D15' => 'Ngữ văn, Địa lí, Tiếng Anh',
        'X02' => 'Môn năng khiếu (tuỳ quy định)',
    ];

    public function conversion()
    {
        // Lấy toàn bộ độ chênh (đang dùng mốc D01; nếu bạn có mốc khác, có thể mở rộng)
        $offsets = ComboOffset::query()
            ->where('active', true)
            ->get(['combo_code', 'base_code', 'method', 'delta']);

        // Mặc định chọn D01 là base ở view/JS
        return view('user.conversion', [
            'comboLabels' => $this->comboLabels,
            'methods'     => ['PT1', 'PT2'],
            'offsets'     => $offsets,   // đưa sang JS để tra cứu tại client
        ]);
    }

    public function wishesStore(Request $request)
    {
        // validate top-level
        $request->validate([
            'exam_id'         => ['required', 'string', 'max:50'],
            'converted_score' => ['nullable', 'numeric', 'between:0,30'],
            'nguyenvong'                => ['required', 'array', 'min:1', 'max:20'],
            'nguyenvong.*.major_code'   => ['required', 'string', 'max:20'],
        ], [
            'exam_id.required' => 'Vui lòng nhập Số báo danh.',
        ]);

        // chuẩn hoá dữ liệu NV
        $rows = collect($request->input('nguyenvong', []))
            ->map(fn($r) => ['major_code' => strtoupper(trim($r['major_code'] ?? ''))])
            ->filter(fn($r) => $r['major_code'] !== '');

        if ($rows->isEmpty()) {
            return back()->withErrors(['nguyenvong' => 'Vui lòng chọn ít nhất 1 chuyên ngành.'])->withInput();
        }

        // loại trùng nhưng giữ thứ tự
        $codes = [];
        foreach ($rows as $r) {
            if (!in_array($r['major_code'], $codes, true)) $codes[] = $r['major_code'];
        }

        // check mã ngành hợp lệ
        $valid = Major::whereIn('code', $codes)->where('active', true)->pluck('code')->all();
        $invalid = array_values(array_diff($codes, $valid));
        if ($invalid) {
            return back()->withErrors(['nguyenvong' => 'Mã ngành không hợp lệ/không mở: ' . implode(', ', $invalid)])->withInput();
        }

        // chuẩn hoá điểm quy đổi (cho phép nhập "26,5")
        $converted = null;
        if ($request->filled('converted_score')) {
            $converted = (float) str_replace(',', '.', $request->input('converted_score'));
        }

        $examId = $request->input('exam_id');
        $userId = Auth::id();

        DB::transaction(function () use ($userId, $codes, $examId, $converted) {
            Wish::where('user_id', $userId)->delete();

            foreach ($codes as $i => $code) {
                Wish::create([
                    'user_id'         => $userId,
                    'major_code'      => $code,
                    'order_no'        => $i + 1,
                    'exam_id'         => $examId,     // <— LƯU exam_id
                    'converted_score' => $converted,  // <— LƯU converted_score (nếu có)
                    'status'          => 'pending',
                ]);
            }
        });

        return redirect()->back()->with('success', 'Đã lưu nguyện vọng.');
    }
}
