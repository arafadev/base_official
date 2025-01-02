<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Provider\ProviderLoginController;


Route::group(['prefix' => 'provider', 'middleware' => 'guest:provider'], function () {
    // Route::get('login', [ProviderLoginController::class, 'getLogin'])->name('provider.login.form');
    // Route::post('login', [ProviderLoginController::class, 'login'])->name('provider.login');
});

Route::group(['prefix' => 'provider', 'middleware' => 'auth:provider'], function () {

});
