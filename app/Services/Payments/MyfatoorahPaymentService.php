<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;
use App\Enums\PaymentGatwaysEnums;
use App\Enums\PaymentTransactions;
use Illuminate\Support\Facades\Storage;
use App\Services\Payments\BasePaymentService;
use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Services\Payments\PaymentTransactionService;

class MyfatoorahPaymentService extends BasePaymentService implements PaymentGatewayInterface
{

    protected $base_url;
    protected $api_key;
    protected array $header;


    public function __construct()
    {
        $this->base_url = config('payments.Myfatoorah.BASE_URL');
        $this->api_key = config('payments.Myfatoorah.API_KEY');
        $this->header = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->api_key,  
        ];
    }

    public function sendPayment(Request $request): array
    {

        //validate data before sending it
        $data = $request->all();
        $data['NotificationOption'] = "LNK";
        $data['Language'] = "en";

        $data['callBackUrl'] = $request->getSchemeAndHttpHost() . '/api/payment/callback';

        $response = $this->buildRequest('POST', '/v2/sendPayment', $data);

        $responseData = $response->getData(true)['data'];


        //TODO => Custom payment transaction service to save transaction data in database
        // (new PaymentTransactionService())->createPaymentTransaction(
        //     $request->InvoiceValue,
        //     PaymentTransactions::PAYORDER,
        //     'App\Models\Order', // transactionable_type
        //     1 , // transactionable_id
        //     $responseData['Data']['InvoiceId'],
        //     $responseData,
        //     PaymentGatwaysEnums::MYFATOORAH,
        //     $request->DisplayCurrencyIso,
        //     [
        //         'user_id' => 1,  //TODO id of auth user here...
        //         'item_id' => 1,  // TODO item_id of order | reservation | product ...etc
        //         'type' =>  'order',  //TODO course  | lecture | exam | reservation | product ...etc
        //     ]
        // );

        //handel payment response data and return it
        if ($response->getData(true)['success']) {
            // return $response;  
            return ['success' => true, 'url' => $response->getData(true)['data']['Data']['InvoiceURL']];
        }

        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request)
    {
        $data=[
            'KeyType' => 'paymentId',
            'Key' => $request->input('paymentId'),
        ];

        $response=$this->buildRequest('POST', '/v2/getPaymentStatus', $data);
        $response_data=$response->getData(true);

        Storage::put('myfatoorah_response.json',json_encode([
            'myfatoorah_callback_response'=>$request->all(),
            'myfatoorah_response_status'=>$response_data
        ]));   

        if($response_data['data']['Data']['InvoiceStatus']==='Pending'){
            return ['status' => true, 'transaction_id' => $response_data['data']['Data']['InvoiceId']];
        }
        return false ;
    }
}
