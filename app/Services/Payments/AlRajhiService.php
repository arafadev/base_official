<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;
use App\Enums\PaymentGatwaysEnums;
use App\Enums\PaymentTransactions;
use Illuminate\Support\Facades\Storage;
use App\Services\Payments\BasePaymentService;
use App\Services\Payments\AlRajhiEncryptionService;
use App\Interfaces\Payments\PaymentGatewayInterface;

class AlRajhiService extends BasePaymentService implements PaymentGatewayInterface
{

    protected AlRajhiEncryptionService $encryptionService;

    protected $id;
    protected $password;
    public function __construct()
    {
        $this->encryptionService = new AlRajhiEncryptionService();

        $this->base_url = config('payments.Alrajhibank.BASE_URL');
        $this->id = config('payments.Alrajhibank.TRANSPORTAL_ID');
        $this->password =  config('payments.Alrajhibank.PASSWORD');
        $this->header = [
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
        ];
    }

    public function sendPayment(Request $request): array
    {
        $plainData = [
            [
                "id" => $this->id,
                "password" => $this->password,
                "action" => "1",
                "currencyCode" => "682", // or 966 i don't sure ... but in docs it's 682
                "errorURL" => route('payment.failed'),
                "responseURL" => $request->getSchemeAndHttpHost() . "/api/payment/callback",
                "trackId" => uniqid(),
                "amt" => $request->get('amount'),
            ]
        ];
        
        // Step 2: Encrypt Plain Data
        $encryptedData = $this->encryptionService->encrypt(json_encode($plainData));

        $encryptedRequest = [
            [
                "id" => $this->id,
                "trandata" => $encryptedData,
                "errorURL" => route('payment.failed'),
                "responseURL" => $request->getSchemeAndHttpHost()."/api/payment/callback",
            ]
        ];


        $response = $this->buildRequest('POST', '/pg/payment/hosted.htm', $encryptedRequest);

        // Storage::put('response.json', json_encode($response));

        $response_data = $response->getData(true);

        $result = $response_data['data'][0]['result'];

        [$paymentID, $url] = explode(':', $result, 2);

        $newUrl = $url . '?PaymentID=' . $paymentID;

        if ($response_data['success']) {
            
            //TODO : save payment transaction as you like
            (new PaymentTransactionService())->createPaymentTransaction(
                $plainData[0]['amt'],               
                PaymentTransactions::PAYORDER,         
                'App\Models\Order',                    
                1,                                     
                $paymentID,                         
                $response_data['data'][0],            
                PaymentGatwaysEnums::ALRAJHI,          
                "682", // or 966 i don't sure ... but in docs it's 682                                 
                [
                    'user_id' => 1,   
                    'item_id' => 1,  
                    'type'    => 'order',  
                ]
            );
    
            return [
                'success' => true,
                'url'     => $newUrl,
            ];
        }
        return [
            'success' => false,
            'url' => route('payment.failed')
        ];

    }

    public function callBack(Request $request)
    {
        $tran_data = $this->encryptionService->decrypt($request->get('trandata'));


        $response = urldecode($tran_data);
        $data = json_decode($response, true);

        if (isset($data[0]['result']) && $data[0]['result'] === 'CAPTURED') {

            // Storage::put('alrajhi_callback.json', json_encode([
            //         'callback_response' => $request->all(),
            //         'callback_after_encode' => $data,
            //     ]
            // ));

            return true;
        }

        return false;

    }
}