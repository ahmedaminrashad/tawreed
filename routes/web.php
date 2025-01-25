<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CountryController;
use App\Http\Controllers\Web\HomePageController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\TenderController;
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

Route::get('/about', [HomePageController::class, 'about'])->name('about');

Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');

Route::get('/privacy-policy', [HomePageController::class, 'privacy'])->name('privacy');

Route::get('/terms-conditions', [HomePageController::class, 'terms'])->name('terms');

Route::get('/categories', [WorkCategoryController::class, 'index'])->name('categories.index');

Route::get('/country/{country_id}/cities', [CountryController::class, 'cities'])->name('country.list.cities');

// Route User Resend OTP Password
Route::post('resend-otp', [AuthController::class, 'resendOTP'])->name('resend.otp');

// Before Login Routes
Route::group(['middleware' => ['guest:web']], function () {
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
Route::group(['middleware' => ['auth:web']], function () {
    // Logout Route
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        // Profile Route
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        // Edit Profile Route
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        // Profile Store
        Route::post('/', [ProfileController::class, 'settings'])->name('store');

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            // Settings Route
            Route::get('/', [ProfileController::class, 'settings'])->name('index');
            // Store Notifications Setting Route
            Route::post('/notifications', [ProfileController::class, 'storeNotifications'])->name('notifications.store');
            // Update Password Route
            Route::post('/password/change', [ProfileController::class, 'updatePassword'])->name('password.update');
            // Update Profile Email Route
            Route::post('/email/update', [ProfileController::class, 'updateProfileEmail'])->name('email.update');
            // Verify Email Update Route
            Route::post('/verify/email/update', [ProfileController::class, 'verifyUpdateEmail'])->name('verify.email.update');
        });
    });

    Route::group(['middleware' => ['check-tender']], function () {
        // Create Tender Route
        Route::get('tenders/create/{tender?}', [TenderController::class, 'create'])->name('tenders.create');
        // Store Tender Route
        Route::post('tenders/store/{tender?}', [TenderController::class, 'store'])->name('tenders.store');
        // Tender Items Route
        Route::get('tenders/{tender}/items', [TenderController::class, 'storeItemsForm'])->name('tenders.items.form');
        // Store Tender Items Route
        Route::post('tenders/{tender}/items', [TenderController::class, 'storeItems'])->name('tenders.items.store');
        // Tender Review Route
        Route::get('tenders/{tender}/review', [TenderController::class, 'reviewTender'])->name('tenders.review');
        // Publish Tender Route
        Route::post('tenders/{tender}/publish', [TenderController::class, 'publishTender'])->name('tenders.publish');
    });
});
