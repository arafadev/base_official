<?php

namespace App\Interfaces\Payments;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function sendPayment(Request $request);

    public function callBack(Request $request);
}