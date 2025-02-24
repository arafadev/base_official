<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Controllers\Payments\TapPaymentController;
use App\Http\Controllers\Payments\PaymobPaymentController;
use App\Http\Controllers\Payments\PayPalPaymentController;
use App\Http\Controllers\Payments\StripePaymentController;
use App\Http\Controllers\Payments\MoyasarPaymentController;
use App\Http\Controllers\Payments\MyfatoorahPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/payment/process', [PaymobPaymentController::class, 'paymentProcess']);
// Route::match(['GET','POST'],'/payment/callback', [PaymobPaymentController::class, 'callBack']);

Route::post('/payment/process', [StripePaymentController::class, 'paymentProcess']);
Route::match(['GET','POST'],'/payment/callback', [StripePaymentController::class, 'callBack']);