<?php

namespace App\Services\Payments;

use App\Models\PaymentTransaction;

class PaymentTransactionService
{
    
    function createPaymentTransaction($amount,$type , $transactionable_type , $transactionable_id , $transaction_id , $payemtResponse ,$paymentName,$currency_code ,  $data = [] ) {

        PaymentTransaction::create([
            'amount'           => $amount ,
            'type'             => $type,
            'trans_type'       => $transactionable_type,
            'trans_id'         => $transactionable_id ,
            'transaction_id'   => $transaction_id,
            'getaway_response' => $payemtResponse,
            'payment_getaway'  => $paymentName,
            'currency_code'    => $currency_code,
            'status'           => 'pending',
            'data'              => $data
        ]);
    }

}