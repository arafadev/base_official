<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;


Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {
  
});

Route::group(['middleware' => ['guest:sanctum']], function () {

    // authentication
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('check-code', [AuthController::class, 'checkCode']);
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
    });
});

Route::group(['middleware' => ['auth:sanctum', 'is-active']], function () {
 
    Route::get('test', function () {
        return 'active test !';
    });
});
