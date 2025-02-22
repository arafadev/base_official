<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Payments\PaymentController;

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

Route::name('site.')->controller(SiteController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/service', 'service')->name('service');
    Route::post('/contact/store', 'contactStore')->name('contact.store');
    Route::get('/contact', 'contact')->name('contact');
});

// Route::get('login' , function (){ return 'login page';})->name('login');
// payment
// هنا بيرد عليك بيقولك نجحت العمليه او فشلت ف حاله العمليه نجحت او فشلت هيرن الراوت دا 
// Route::get('payment/get-payment-status/{brand_id?}',  [PaymentService::class, 'callback'])->name('payment.getPaymentStatus');
// Route::get('payment/callbackStatus/{transaction_id}',  [PaymentService::class, 'callbackStatus'])->name('payment.callbackStatus');
//           // payment

Route::get('/payment-success/{transaction_id}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.failed');
