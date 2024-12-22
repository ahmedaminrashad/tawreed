<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomePageController;
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

Route::get('/', [HomePageController::class, 'index'])->name('home');
// Before Login Routes
Route::group(['middleware' => ['guest:web']], function () {
    // Route Login
    // Route::get('login', [AuthController::class, 'loginForm'])->name('login.form');
    // Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::post('verify-otp', [AuthController::class, 'verifyOTP'])->name('verify.otp');
    Route::post('resend-otp', [AuthController::class, 'resendOTP'])->name('resend.otp');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
});