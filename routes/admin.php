<?php

use App\Http\Controllers\Admin\ActivityClassificationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CancellationReasonController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RejectionReasonController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WorkCategoryClassificationController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    // Before Login Admin Routes
    Route::group(['middleware' => ['guest:admin']], function () {
        // Route Login
        Route::get('login', [AuthController::class, 'loginForm'])->name('login.form');
        Route::post('login', [AuthController::class, 'login'])->name('login');

        // Forget Password Route
        Route::get('forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('forget.password.form');
        Route::post('forgotPassword', [AuthController::class, 'forgotPassword'])->name('forget.password');

        // Forget Password OTP Route
        Route::get('forgot-password/otp', [AuthController::class, 'forgotPasswordOTPForm'])->name('forget.password.otp.form');
        Route::post('forgotPassword/otp', [AuthController::class, 'forgotPasswordOTP'])->name('forget.password.otp');

        // Reset Password Route
        Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('reset.password.form');
        Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('reset.password');
    });

    // After Login Admin Routes
    Route::group(['middleware' => ['auth:admin']], function () {
        // Logout Route
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => ['auth:admin', 'check-permission']], function () {
        // Dashboard Homepage Route
        Route::get('/', [DashboardController::class, 'index'])->name('home');

        // Roles Routes
        Route::resource('roles', RoleController::class)->except('destroy', 'show');

        // Admins Routes
        Route::resource('admins', AdminController::class);
        Route::put('admins/{admin}/reset/password', [AdminController::class, 'resetPassword'])->name('admins.reset.password');

        // Countries Routes
        Route::resource('countries', CountryController::class);

        // Cities Routes
        Route::resource('cities', CityController::class);

        // Work Category Classifications Routes
        Route::resource('classifications', WorkCategoryClassificationController::class);

        // Activity Classifications Routes
        Route::resource('activity-classifications', ActivityClassificationController::class);

        // Measurement Units Routes
        Route::resource('units', UnitController::class);

        // Cancellation Reasons Routes
        Route::resource('cancellations', CancellationReasonController::class);

        // Rejection Reasons Routes
        Route::resource('rejections', RejectionReasonController::class);

        // Settings Routes
        Route::resource('settings', SettingController::class)->except('create', 'store', 'destroy');
    });
});
