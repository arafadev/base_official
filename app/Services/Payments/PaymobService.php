<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;
use App\Enums\PaymentGatwaysEnums;
use App\Enums\PaymentTransactions;
use App\Services\Payments\BasePaymentService;
use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Services\Payments\PaymentTransactionService;

class PaymobService extends BasePaymentService implements PaymentGatewayInterface
{

    protected $api_key;
    protected $integrations_id;
    protected $base_url;
    protected array $header;


    public function __construct()
    {
        $this->api_key = config('payments.Paymob.API_KEY');
        $this->integrations_id = config('payments.Paymob.INTEGRATIONS_ID');
        $this->base_url = config('payments.Paymob.BASE_URL');
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }


    //first generate token to access api
    protected function generateToken()
    {
        $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);
        return $response->getData(true)['data']['token'];
    }

    public function sendPayment(Request $request): array
    {

        $this->header['Authorization'] = 'Bearer ' . $this->generateToken();

        //validate data before sending it
        $data = $request->all();
        $data['api_source'] = "INVOICE";
        $data['integrations'] = $this->integrations_id;

        $response = $this->buildRequest('POST', '/api/ecommerce/orders', $data);


        (new PaymentTransactionService())->createPaymentTransaction(
            $response->getData(true)['data']['amount_cents'],
            PaymentTransactions::PAYORDER,
            'App\Models\Order', // transactionable_type
            1 , // transactionable_id
            $response->getData(true)['data']['id'],
            $response->getData(true)['data'],
            PaymentGatwaysEnums::PAYMOB,
            $response->getData(true)['data']['currency'],
            [
                'user_id' => 1,  //^ TODO id of auth user here...
                'item_id' => 1,  //^ TODO item_id of order | reservation | product ...etc
                'type' =>  'order',  //^   course  | lecture | exam | reservation | product ...etc
            ]
        );

        //handel payment response data and return it
        if ($response->getData(true)['success']) {
            // return $response;  
            return ['success' => true, 'url' => $response->getData(true)['data']['url']];
        }

        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request)
    {
        $response = $request->all();

        // Storage::put('paymob_response.json', json_encode($request->all())); // store response in file to show all response (this for debugging)

        if (isset($response['success']) && $response['success'] === 'true') {
            return ['status' => true, 'transaction_id' => $response['id'] ];
        }
        return false;
    }
}
