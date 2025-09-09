<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\DaoTaoController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ComboOffsetController;

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
    Route::post('/profile', [UserController::class, 'save'])->name('profile.save');
    Route::get('/dang-ky-nguyen-vong', [UserController::class, 'registerWishes'])->name('registerWishes');
    Route::post('/dang-ky-nguyen-vong', [UserController::class, 'wishesStore'])->name('wishesStore');
    Route::get('/quy-doi-diem', [UserController::class, 'conversion'])->name('conversion');
    Route::get('/ket-qua', [UserController::class, 'result'])->name('result');
});
// Đào tạo
Route::prefix('dao-tao')->middleware('auth')->middleware('role:1')->group(function () {
    Route::get('/', [DaoTaoController::class, 'index'])->name('homeDaoTao');
    Route::get('/xettuyen', [DaoTaoController::class, 'xettuyen'])->name('xettuyen');
    Route::post('/xet-tuyen', [DaoTaoController::class, 'chayXetTuyen'])->name('xettuyen.chay');
    Route::resource('/majors', MajorController::class)->except(['create', 'show', 'edit']);
    Route::get('/candidates', [CandidateController::class, 'index'])
        ->name('candidates.index');
    Route::resource('/combo-offsets', ComboOffsetController::class)
        ->parameters(['combo-offsets' => 'offset'])
        ->except(['create', 'show', 'edit']);
    Route::get('/wishes', [WishController::class, 'index'])
        ->name('wishes.index');
    Route::post('/wishes/run-quota', [WishController::class, 'runQuota'])
        ->name('wishes.runQuota');
    Route::get('/ket-qua-xet-tuyen', [DaoTaoController::class, 'ketquaxettuyen'])->name('ketquaxettuyen');
    
});

// Hiệu trưởng - Boss
Route::middleware(['auth', 'role:2'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('homeAdmin');
    Route::get('/account', [AdminController::class, 'account'])->name('account');
});
