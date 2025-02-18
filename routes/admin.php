<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SMSController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\PaymentBrandController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\RoleAndPermissions\RoleController;
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
            Route::get('toggle/{id}/{field}', [AdminController::class, 'toggle'])->name('admins.toggle');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admins.delete');
            Route::delete('deleteSelected', [AdminController::class, 'deleteSelected'])->name('admins.deleteSelected');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('create', [UserController::class, 'create'])->name('users.create');
            Route::post('store', [UserController::class, 'store'])->name('users.store');
            Route::get('{id}', [UserController::class, 'show'])->name('users.show');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::post('update/{id}', [UserController::class, 'update'])->name('users.update');
            Route::get('toggle/{id}/{field}', [UserController::class, 'toggle'])->name('users.toggle');
            Route::get('delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            Route::delete('deleteSelected', [UserController::class, 'deleteSelected'])->name('users.deleteSelected');
        });

        Route::group(['prefix' => 'providers'], function () {
            Route::get('/', [ProviderController::class, 'index'])->name('providers.index');
            Route::get('create', [ProviderController::class, 'create'])->name('providers.create');
            Route::post('store', [ProviderController::class, 'store'])->name('providers.store');
            Route::get('{id}', [ProviderController::class, 'show'])->name('providers.show');
            Route::get('edit/{id}', [ProviderController::class, 'edit'])->name('providers.edit');
            Route::post('update/{id}', [ProviderController::class, 'update'])->name('providers.update');
            Route::get('toggle/{id}/{field}', [ProviderController::class, 'toggle'])->name('providers.toggle');
            Route::get('delete/{id}', [ProviderController::class, 'delete'])->name('providers.delete');
            Route::delete('deleteSelected', [ProviderController::class, 'deleteSelected'])->name('providers.deleteSelected');
        });
        Route::group(['prefix' => 'regions'], function () {
            Route::get('/', [RegionController::class, 'index'])->name('regions.index');
            Route::get('create', [RegionController::class, 'create'])->name('regions.create');
            Route::post('store', [RegionController::class, 'store'])->name('regions.store');
            Route::get('{id}', [RegionController::class, 'show'])->name('regions.show');
            Route::get('edit/{id}', [RegionController::class, 'edit'])->name('regions.edit');
            Route::post('update/{id}', [RegionController::class, 'update'])->name('regions.update');
            Route::get('delete/{id}', [RegionController::class, 'delete'])->name('regions.delete');
            Route::delete('deleteSelected', [RegionController::class, 'deleteSelected'])->name('regions.deleteSelected');
        });
        Route::group(['prefix' => 'site_settings'], function () {
            Route::get('/', [SiteSettingController::class, 'index'])->name('site_settings.index');
            Route::get('create', [SiteSettingController::class, 'create'])->name('site_settings.create');
            Route::post('store', [SiteSettingController::class, 'store'])->name('site_settings.store');
            Route::get('edit/{id}', [SiteSettingController::class, 'edit'])->name('site_settings.edit');
            Route::post('update', [SiteSettingController::class, 'update'])->name('site_settings.update');
            Route::get('delete/{id}', [SiteSettingController::class, 'delete'])->name('site_settings.delete');
            Route::delete('deleteSelected', [SiteSettingController::class, 'deleteSelected'])->name('site_settings.deleteSelected');
        });
        Route::group(['prefix' => 'reports'], function () {
            Route::get('/', [ReportController::class, 'index'])->name('reports.index');
            Route::get('create', [ReportController::class, 'create'])->name('reports.create');
            Route::post('store', [ReportController::class, 'store'])->name('reports.store');
            Route::get('edit/{id}', [ReportController::class, 'edit'])->name('reports.edit');
            Route::post('update', [ReportController::class, 'update'])->name('reports.update');
            Route::get('delete/{id}', [ReportController::class, 'delete'])->name('reports.delete');
            Route::delete('deleteSelected', [ReportController::class, 'deleteSelected'])->name('reports.deleteSelected');
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::post('update/{id}', [RoleController::class, 'update'])->name('roles.update');
            Route::get('create/roles_has_permission', [RoleController::class, 'createRoleHasPermission'])->name('role.roles_has_permission.create');
            Route::post('store/roles_has_permission', [RoleController::class, 'storeRoleHasPermission'])->name('role.roles_has_permission.store');
            Route::get('show/roles_has_permission', [RoleController::class, 'show_roles_has_permission'])->name('role.show_roles_has_permission.show');
            Route::get('edit/roles_has_permission/{role_id}', [RoleController::class, 'edit_roles_has_permission'])->name('role.edit_roles_has_permission.edit');
            Route::post('update/roles_has_permission/{role_id}', [RoleController::class, 'updateRoleHasPermission'])->name('role.roles_has_permission.update');
            Route::get('delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');
            Route::delete('deleteSelected', [RoleController::class, 'deleteSelected'])->name('roles.deleteSelected');
        });

        Route::group(['prefix' => 'sms'], function () {
            Route::get('/', [SMSController::class, 'index'])->name('sms.index');
            Route::post('change', [SMSController::class, 'change'])->name('sms.change');
            Route::post('update/{id}', [SMSController::class, 'update'])->name('sms.update');
        });
    });
});