<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Payments\PaymobService;
use App\Interfaces\Payments\PaymentGatewayInterface;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {

        // $this->app->bind(PaymentGatewayInterface::class, PaymobService::class);
        
        //if you have multi payment gateways and want to use one of them you shoud send the pramater with data
//        $this->app->singleton(PaymentGatewayInterface::class, function ($app) {
//            $gatewayType = request()->get('gateway_type');
//            return match ($gatewayType) {
//
//
//                default => throw new \Exception("Unsupported gateway type"),
//            };

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
