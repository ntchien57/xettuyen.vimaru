<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
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

    public function registerWishes(){
        return view('user.register');
    }
}
