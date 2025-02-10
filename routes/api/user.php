<?php

use App\Models\Admin;
use App\Notifications\NotifyAdmin;
use Illuminate\Support\Facades\Route;
use App\Notifications\InviteFriendNotification;
use App\Http\Controllers\Api\User\AuthController;


Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {});

Route::group(['middleware' => ['guest:sanctum']], function () {

    // authentication
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('active', [AuthController::class, 'active']);
    Route::get('resend-code', [AuthController::class, 'resendCode']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        // update phone
        // Route::post('send-code-current-phone', [ProfileController::class, 'sendCodeCurrentPhone']);
        // Route::post('check-code-current-phone', [ProfileController::class, 'checkCodeCurrentPhone']);
        // Route::post('change-phone-send-code', [ProfileController::class, 'changePhoneSendCode']);
        // Route::post('check-code-new-phone', [ProfileController::class, 'checkCodeNewPhone']);
        
        Route::get('profile', function() {
            
            Admin::find(1)->notify(new NotifyAdmin());

        });
    });
});

Route::group(['middleware' => ['auth:sanctum', 'is-active']], function () {});
