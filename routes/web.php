<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaoTaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'showloginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Sinh viên
Route::middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});

// Đào tạo
Route::prefix('dao-tao')->middleware('auth')->middleware('role:1')->group(function () {
    Route::get('/', [DaoTaoController::class, 'index'])->name('homeDaoTao');
    Route::get('/xettuyen', [DaoTaoController::class, 'xettuyen'])->name('xettuyen');
    Route::post('/xet-tuyen', [DaoTaoController::class, 'chayXetTuyen'])->name('xettuyen.chay');
});

// Hiệu trưởng - Boss
Route::middleware(['auth', 'role:2'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('homeAdmin');
    Route::get('/account', [AdminController::class, 'account'])->name('account');
});



