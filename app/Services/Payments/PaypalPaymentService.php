<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;
use App\Enums\PaymentGatwaysEnums;
use App\Enums\PaymentTransactions;
use Illuminate\Support\Facades\Storage;
use App\Services\Payments\BasePaymentService;
use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Services\Payments\PaymentTransactionService;

class PaypalPaymentService extends BasePaymentService implements PaymentGatewayInterface
{

    protected $client_id;
    protected $client_secret;
    protected array $header;


    public function __construct()
    {
        $this->base_url = config('payments.Paypal.BASE_URL');
        $this->client_id = config('payments.Paypal.CLIENT_ID');
        $this->client_secret = config('payments.Paypal.CLIENT_SECRET');
        $this->header = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Basic "  . base64_encode("$this->client_id:$this->client_secret"),  // Authorization: Basic <base64 encoded client_id:client_secret>
        ];
    }

    public function sendPayment(Request $request): array
    {


        $data = $this->formatData($request);
        $response = $this->buildRequest("POST", "/v2/checkout/orders", $data);

        $responseData = $response->getData(true)['data'];

        //TODO => Custom payment transaction service to save transaction data in database
        (new PaymentTransactionService())->createPaymentTransaction(
            $request['amount']['value'], // amount
            PaymentTransactions::PAYORDER,
            'App\Models\Order', // transactionable_type
            1,
            $responseData['id'], // transactionable_id
            $responseData,
            PaymentGatwaysEnums::PAYPAL,
            $request['amount']['currency_code'],
            [
                'user_id' => 1,  //TODO id of auth user here...
                'item_id' => 1,  // TODO item_id of order | reservation | product ...etc
                'type' =>  'order',  //TODO course  | lecture | exam | reservation | product ...etc
            ]
        );

        //handel payment response data and return it
        if ($response->getData(true)['success']) {

            return ['success' => true, 'url' => $response->getData(true)['data']['links'][1]['href']];
        }
        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request)
    {
        $token = $request->get('token');  // transaction_id
        $response = $this->buildRequest('POST', "/v2/checkout/orders/$token/capture");

        // Storage::put('paypal.json', json_encode([
        //     'callback_response' => $request->all(),
        //     'capture_response' => $response
        // ]));
        if ($response->getData(true)['success'] && $response->getData(true)['data']['status'] === 'COMPLETED') {
            return ['status' => true, 'transaction_id' => $token];
        }
        return false;
    }

    public function formatData($request): array
    {
        return [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => $request->input("amount"),
                ]
            ],
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "return_url" => $request->getSchemeAndHttpHost() . '/api/payment/callback',
                        "cancel_url" => route("payment.failed"),
                    ]
                ]
            ]
        ];
    }
}
