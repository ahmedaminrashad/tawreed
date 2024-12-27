<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomePageController;
use App\Http\Controllers\Web\WorkCategoryController;
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

Route::get('/categories', [WorkCategoryController::class, 'index'])->name('categories.index');

// Before Login Routes
Route::group(['middleware' => ['guest:api']], function () {
    /*********************************Auth Routes***********************/

    // Route Login
    Route::post('login', [AuthController::class, 'login'])->name('login');

    // Route Register
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // Route Verify User OTP
    Route::post('verify-otp', [AuthController::class, 'verifyOTP'])->name('verify.otp');

    // Route User Forget Password
    Route::post('forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');

    // Route User Reset Password
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

    /*********************************Auth Routes***********************/
});

// After Login Routes
Route::group(['middleware' => ['auth:api']], function () {
    // Route logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
