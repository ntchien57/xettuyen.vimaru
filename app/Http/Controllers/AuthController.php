<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        // Kiểm tra email tồn tại
        if (User::where('email', $request->email)->exists()) {
            return back()->with('error', 'Email đã được sử dụng.')->withInput();
        }

        // Kiểm tra CCCD tồn tại
        if (User::where('cccd', $request->cccd)->exists()) {
            return back()->with('error', 'CCCD đã được sử dụng.')->withInput();
        }
        User::create([
            'hoten' => $request->name,
            'email' => $request->email,
            'cccd' => $request->cccd,
            'matkhau' => Hash::make($request->password),
            'role' => 0
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập.');
    }

    public function login(Request $request)
    {

        $user = User::where('cccd', $request->cccd)
            ->orWhere('email', $request->cccd)
            ->first();
        if (!$user) {
            return back()->with('error', 'Tài khoản không tồn tại')->withInput();
        }

        if ($user->active == 0) {
            return back()->with('error', 'Tài khoản bị khóa')->withInput();
        }

        if (!Hash::check($request->password, $user->matkhau)) {
            return back()->with('error', 'Mật khẩu không đúng')->withInput();
        }

        Auth::login($user);

        if (Auth::user()->role == 0) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        } elseif (Auth::user()->role == 1) {
            return redirect()->route('homeDaoTao')->with('success', 'Đăng nhập thành công!');
        } elseif (Auth::user()->role == 2) {
            return redirect()->route('homeAdmin')->with('success', 'Đăng nhập thành công!');
        } else {
            Auth::logout();
            return back()->with('error', 'Tài khoản không có quyền truy cập.');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
