<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CountryController;
use App\Http\Controllers\Web\HomePageController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\ProposalController;
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

Route::group(['middleware' => ['check-tender'], 'prefix' => 'tenders', 'as' => 'tenders.'], function () {
    // Tenders List Route
    Route::get('/', [TenderController::class, 'index'])->name('index');
    // Filter Tenders Route
    Route::post('/filter', [TenderController::class, 'indexAjax'])->name('filter');
    // Show Tender Route
    Route::get('/{tender}/show', [TenderController::class, 'show'])->name('show');
    // Show Tender Proposals Route
    Route::get('/{tender}/show/proposals', [TenderController::class, 'showProposals'])->name('proposals.show');
});

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
        Route::post('/', [ProfileController::class, 'store'])->name('store');
        // Profile Tenders
        Route::get('/tenders', [ProfileController::class, 'tenders'])->name('tenders');
        // Profile Proposals
        Route::get('/proposals', [ProfileController::class, 'proposals'])->name('proposals');
        // Profile Wallet
        Route::get('/wallet', [ProfileController::class, 'wallet'])->name('wallet');

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

    Route::group(['middleware' => ['check-tender'], 'prefix' => 'tenders', 'as' => 'tenders.'], function () {
        // Create Tender Route
        Route::get('create/{tender?}', [TenderController::class, 'create'])->name('create');
        // Store Tender Route
        Route::post('store/{tender?}', [TenderController::class, 'store'])->name('store');
        // Tender Items Route
        Route::get('{tender}/items', [TenderController::class, 'storeItemsForm'])->name('items.form');
        // Store Tender Items Route
        Route::post('{tender}/items', [TenderController::class, 'storeItems'])->name('items.store');
        // Tender Review Route
        Route::get('{tender}/review', [TenderController::class, 'reviewTender'])->name('review');
        // Publish Tender Route
        Route::post('{tender}/publish', [TenderController::class, 'publishTender'])->name('publish');
    });

    Route::group(['prefix' => 'proposals', 'as' => 'proposals.'], function () {
        // Show Proposal Route
        Route::get('/{proposal}/show', [ProposalController::class, 'show'])->name('show');
        // Update Proposal Status Route
        Route::post('/{proposal}/status/update', [ProposalController::class, 'updateStatus'])->name('update.status');
        // Proposal Initial Accept Route
        Route::post('/{proposal}/inital/accept', [ProposalController::class, 'initialAccept'])->name('initial.accept');
        // Submit Proposal Request Sample Route
        Route::post('/{proposal}/request/sample', [ProposalController::class, 'requestSample'])->name('request.sample');
        // Submit Proposal Sample Sent Route
        Route::post('/{proposal}/sample/sent', [ProposalController::class, 'sampleSent'])->name('sample.sent');
        // Submit Proposal Reject Route
        Route::post('/{proposal}/reject', [ProposalController::class, 'reject'])->name('reject');
        // Submit Proposal Withdraw Route
        Route::post('/{proposal}/withdraw', [ProposalController::class, 'withdraw'])->name('withdraw');
        // Submit Proposal Final Acceptance Route
        Route::post('/{proposal}/final/accept', [ProposalController::class, 'finalAccept'])->name('final.accept');
    });

    Route::group(['prefix' => 'tenders', 'as' => 'tenders.'], function () {
        Route::group(['as' => 'proposals.'], function () {
            // Create Tender Proposal Route
            Route::get('{tender}/proposals/items/{proposal?}', [ProposalController::class, 'items'])->name('items');
            // Store Tender Proposal Items Route
            Route::post('{tender}/proposals/items/{proposal?}', [ProposalController::class, 'storeItems'])->name('items.store');
            // Proposal Info Route
            Route::get('{tender}/proposals/{proposal}/info', [ProposalController::class, 'info'])->name('info');
            // Store Proposal Info Route
            Route::post('{tender}/proposals/{proposal}/info', [ProposalController::class, 'storeInfo'])->name('info.store');
            // Proposal Review Route
            Route::get('{tender}/proposals/{proposal}/review', [ProposalController::class, 'reviewProposal'])->name('review');
            // Publish Proposal Route
            Route::post('{tender}/proposals/{proposal}/publish', [ProposalController::class, 'publishProposal'])->name('publish');
        });
    });
});

Route::get('/test', [\App\Http\Controllers\TestController::class, 'test']);;
