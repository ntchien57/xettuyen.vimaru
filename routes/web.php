<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

Route::get('/login', [AuthController::class,'showloginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::get('/register', [AuthController::class,'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class,'register']);
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::get('/profile', [UserController::class,'profile'])->name('profile');
Route::get('/tai-khoan', [AdminController::class,'account'])->name('account');


Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');
