<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;


Route::redirect('/admin', '/admin/login');

Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', [AdminAuthController::class, 'getLogin'])->name('admin.login.form');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
});



Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin', 'as' => 'admin.'], function () {
   
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
    // Route::post('profile/{id}', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');


    

    // Countries routes
    // Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
    // });

    
});

    // Route::put('users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    // Route::delete('users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
