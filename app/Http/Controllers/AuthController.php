<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        User::create([
            'hoten' => $request->name, // Bạn có thể bổ sung trường này từ form nếu cần
            'email' => $request->email,
            'cccd' => $request->cccd,
            'matkhau' => Hash::make($request->password),
            'role' => 0
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập.');
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
