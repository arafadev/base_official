<?php

namespace App\Providers;

use App\Enums\PaymentGatwaysEnums;
use Illuminate\Support\ServiceProvider;
use App\Services\Payments\PaymobService;
use App\Services\Payments\AlRajhiService;
use App\Services\Payments\MoyasarPaymentService;
use App\Services\Payments\MyfatoorahPaymentService;
use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Services\Payments\PaypalPaymentService;
use App\Services\Payments\StripePaymentService;
use App\Services\Payments\TapService;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $gateway = PaymentGatwaysEnums::STRIPE; 

        switch ($gateway) {
            case PaymentGatwaysEnums::MYFATOORAH:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new MyfatoorahPaymentService();
                });
                break;
            case PaymentGatwaysEnums::ALRAJHI:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new AlRajhiService();
                });
                break;
            case PaymentGatwaysEnums::MOYASAR:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new MoyasarPaymentService();
                });
                break;
            case PaymentGatwaysEnums::TAP:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new TapService();
                });
                break;
            case PaymentGatwaysEnums::PAYPAL:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new PaypalPaymentService();
                });
                break;
            case PaymentGatwaysEnums::PAYMOB:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new PaymobService();
                });
                break;
            case PaymentGatwaysEnums::STRIPE:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new StripePaymentService();
                });
                break;
            case PaymentGatwaysEnums::PAYMOB:
                $this->app->bind(PaymentGatewayInterface::class, function () {
                    return new MoyasarPaymentService();
                });
            default:
                dd('Gateway not found');
                break;
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
