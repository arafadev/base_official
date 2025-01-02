<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::redirect('/admin', '/admin/login');

Route::group(['prefix' => LaravelLocalization::setLocale(). '/admin', 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'as' => 'admin.'], function () {
    
    Route::get('login', [AdminAuthController::class, 'getLogin'])->name('login.form')->middleware('guest:admin');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login')->middleware('guest:admin');

        Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // مسارات الدول
        // Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
        // });
    });
});