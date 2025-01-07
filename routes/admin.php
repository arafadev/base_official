<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ServiceController;
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

        Route::group(['prefix' => 'services'], function () {
            Route::get('/', [ServiceController::class, 'index'])->name('services.index');
            Route::get('create', [ServiceController::class, 'create'])->name('services.create');
            Route::post('store', [ServiceController::class, 'store'])->name('services.store');
            Route::get('{id}', [ServiceController::class, 'show'])->name('services.show');
            Route::get('edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
            Route::post('update/{id}', [ServiceController::class, 'update'])->name('services.update');
            Route::get('delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');
            Route::delete('deleteSelected', [ServiceController::class, 'deleteSelected'])->name('services.deleteSelected');
        });

        Route::group(['prefix' => 'countries'], function () {
            Route::get('/', [CountryController::class, 'index'])->name('countries.index');
            Route::get('create', [CountryController::class, 'create'])->name('countries.create');
            Route::post('store', [CountryController::class, 'store'])->name('countries.store');
            Route::get('{id}', [CountryController::class, 'show'])->name('countries.show');
            Route::get('edit/{id}', [CountryController::class, 'edit'])->name('countries.edit');
            Route::post('update/{id}', [CountryController::class, 'update'])->name('countries.update');
            Route::get('delete/{id}', [CountryController::class, 'delete'])->name('countries.delete');
            Route::delete('deleteSelected', [CountryController::class, 'deleteSelected'])->name('countries.deleteSelected');
        });

        Route::group(['prefix' => 'admins'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admins.index');
            Route::get('create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('store', [AdminController::class, 'store'])->name('admins.store');
            Route::get('{id}', [AdminController::class, 'show'])->name('admins.show');
            Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admins.edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('admins.update');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admins.delete');
            Route::delete('deleteSelected', [AdminController::class, 'deleteSelected'])->name('admins.deleteSelected');
        });




    });
});