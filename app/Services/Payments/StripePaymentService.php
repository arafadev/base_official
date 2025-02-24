<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;
use App\Enums\PaymentGatwaysEnums;
use App\Enums\PaymentTransactions;
use Illuminate\Support\Facades\Storage;
use App\Services\Payments\BasePaymentService;
use App\Interfaces\Payments\PaymentGatewayInterface;

class StripePaymentService extends BasePaymentService implements PaymentGatewayInterface
{

    protected mixed $secret_key;
    public function __construct()
    {
        $this->base_url = config('payments.Stripe.BASE_URL');
        $this->secret_key = config('payments.Stripe.SECRET_KEY');
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer ' . $this->secret_key,
        ];
    }

    public function sendPayment(Request $request): array
    {
        $data = $this->formatData($request);
        $response = $this->buildRequest('POST', '/v1/checkout/sessions', $data, 'form_params');
        $responseData = $response->getData(true)['data'];

        //TODO => Custom payment transaction service to save transaction data in database
         (new PaymentTransactionService())->createPaymentTransaction(
            $request['amount'], // amount
            PaymentTransactions::PAYORDER,
            'App\Models\Order', // transactionable_type
            1,
            $responseData['id'], // transactionable_id
            $responseData,
            PaymentGatwaysEnums::STRIPE,
            $responseData['currency'],
            [
                'user_id' => 1,  //TODO id of auth user here...
                'item_id' => 1,  // TODO item_id of order | reservation | product ...etc
                'type' =>  'order',  //TODO course  | lecture | exam | reservation | product ...etc
            ]
        );

        if ($response->getData(true)['success']) {

            return ['success' => true, 'url' => $response->getData(true)['data']['url']];
        }
        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request)
    {
        
        $session_id = $request->get('session_id');  // transaction_id
        $response = $this->buildRequest('GET', '/v1/checkout/sessions/' . $session_id);
    
        $success = $response->getData(true)['success'] && $response->getData(true)['data']['payment_status'] === 'paid';
    
        // Storage::put('stripe.json',json_encode([
        //     'callback_response'=>$request->all(),
        //     'response'=>$response,
        // ]));
        return [
            'status' => $success,
            'transaction_id' => $session_id,
        ];
     
    }

    public function formatData($request): array
    {
        return [
            "success_url" => $request->getSchemeAndHttpHost() . '/api/payment/callback?session_id={CHECKOUT_SESSION_ID}',
            "line_items" => [
                [
                    "price_data" => [
                        "unit_amount" => $request->input('amount') * 100,
                        "currency" => $request->input("currency"),
                        "product_data" => [
                            "name" => "product name",
                            "description" => "description of product"
                        ],
                    ],
                    "quantity" => 1,
                ],
            ],
            "mode" => "payment",
        ];
    }
}
