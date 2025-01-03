<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Service\ServiceController;
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
            Route::delete('bulk-delete', [ServiceController::class, 'deleteSelected'])->name('services.deleteSelected');
            
        });
    });
});