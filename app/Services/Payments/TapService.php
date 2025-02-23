<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;
use App\Enums\PaymentGatwaysEnums;
use App\Enums\PaymentTransactions;
use Illuminate\Support\Facades\Storage;
use App\Services\Payments\BasePaymentService;
use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Services\Payments\PaymentTransactionService;

class TapService extends BasePaymentService implements PaymentGatewayInterface
{

    protected $api_key;
    protected $base_url;


    public function __construct()
    {
        $this->api_key = config('payments.Tap.API_KEY');
        $this->base_url = config('payments.Tap.BASE_URL');
        $this->header = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->api_key
        ];
    }


    public function sendPayment(Request $request): array
    {

        //validate data before sending it
        $data = $request->all();

        $data['source'] = ['id' => 'src_all'];
        $data['redirect'] = ['url' => $request->getSchemeAndHttpHost() . '/api/payment/callback'];

        $response = $this->buildRequest('POST', '/v2/charges/', $data);

        $responseData = json_decode($response->getContent(), true);
        
        //! this is an example of how to save transaction data in database
        (new PaymentTransactionService())->createPaymentTransaction(
           $responseData['data']['amount'],
            PaymentTransactions::PAYORDER,
            'App\Models\Order', // transactionable_type
            1, // transactionable_id
            $responseData['data']['id'],  // transaction_id
            $responseData['data'],
            PaymentGatwaysEnums::TAP,
            $responseData['data']['currency'],
            [
                'user_id' => 1,  //^ TODO id of auth user here...
                'item_id' => 1,  //^ TODO item_id of order | reservation | product ...etc
                'type' =>  'order',  //^   course  | lecture | exam | reservation | product ...etc
            ]
        );

        //handel payment response data and return it
        if ($response->getData(true)['success']) {
            return ['success' => true, 'url' => $response->getData(true)['data']['transaction']['url']];
        }
        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request): bool
    {
        $chargeId = $request->input('tap_id');  // tap_id is the transaction_id that tap payment gateway send to us in the callback request

        $response = $this->buildRequest('GET', "/v2/charges/$chargeId");
        $response_data = $response->getData(true);

        // Storage::put('tap_response.json',json_encode([
        //     'callback_response' => $request->all(),
        //     'response' => $response_data
        // ]));  // store response in file to show all response (this for debugging)

        if($response_data['success'] && $response_data['data']['status'] == 'CAPTURED') {
            return true;
        }
        return false;
    }
}
