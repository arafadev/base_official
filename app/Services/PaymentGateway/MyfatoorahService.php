<?php

namespace App\Services\PaymentGateway;

use App\Traits\LogException;
use Illuminate\Support\Facades\Log;
use App\Traits\ConsumesExternalService;
use GuzzleHttp\Exception\GuzzleException;

class MyfatoorahService
{
    use ConsumesExternalService, LogException;

    protected $API_TOKEN;
    protected $NAME;
    protected $MODE;
    protected $base_url;
    protected $apiVersion;

    public function __construct()
    {
        $this->NAME       = 'Myfatoorah';
        $this->MODE       = config('payments.' . $this->NAME . '.MODE');
        $this->API_TOKEN  = config('payments.' . $this->NAME . '.' . $this->MODE . '_API_TOKEN');
        $this->base_url   = config('payments.' . $this->NAME . '.' . $this->MODE . '_BASE_URL');
        $this->apiVersion = config('payments.' . $this->NAME . '.VERSION') ??  null;
    }

    public function createPayment($request, $user)
    {
        $data = self::getPaymentTransactionInfo($request['amount'], $user);
        //        try {
        $payemtResponse =  $this->makeRequest(
            'POST',
            $this->base_url . '/v2/SendPayment',
            [],
            $data,
            ['Content-Type' => 'application/json', 'authorization' => 'Bearer ' . $this->API_TOKEN],
            true
        );

        return [
            'payment_name'     => $this->NAME,
            'paymentResponse'   => $payemtResponse,
            'transaction_id'   => json_decode($payemtResponse, true)['Data']['InvoiceId'],
            'redirect_url'     => json_decode($payemtResponse, true)['Data']['InvoiceURL'],
        ];

        //        } catch (GuzzleException $exception) {
        //           return $this->logMethodException($exception);
        //        }
    }

    public function getPaymentTransactionInfo($amount, $user): array
    {

        return [
            'CustomerName'       =>  $user->name ?? 'ahmed abdullah',
            'NotificationOption' =>  'Lnk',
            'InvoiceValue'       =>  $amount,
            'MobileCountryCode'  =>  $user->country_code ?? '+966',
            'CustomerMobile'     =>  $user->phone ?? '1234567890',
            'CustomerEmail'      =>  $user->email ?? 'user@gmail.com',
            'Language'           =>  $user->lang ?? 'ar',
            'DisplayCurrencyIso' =>  $user->currency ?? 'SAR',
            'CallBackUrl'        =>  route('payment.getPaymentStatus'),
            'ErrorUrl'           =>  route('payment.getPaymentStatus'),
            'CustomerReference'  =>  1,
            'UserDefinedField'   =>  'user'
        ];
    }

    public function getPaymentStatus($paymentId)
    {
        try {
            $postfields = [
                'Key' => $paymentId,
                'KeyType' => 'paymentId'
            ];
            $response = $this->makeRequest(
                'POST',
                $this->base_url . '/v2/getPaymentStatus',
                [],
                $postfields,
                ['Content-Type' => 'application/json', 'authorization' => 'Bearer ' . $this->API_TOKEN],
                true
            );
            return [
                'status'         => json_decode($response, true)['Data']['InvoiceTransactions'][0]['TransactionStatus'] == 'Failed' ? 0 : 1,
                'transaction_id' => json_decode($response, true)['Data']['InvoiceId'],
            ];
        } catch (GuzzleException $exception) {
            Log::emergency("File:" . $exception->getFile() . "Line:" . $exception->getLine() . "Message:" . $exception->getMessage());
            return [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
            return $this->failMsg(__("messages.something_went_wrong"));
        }
    }
}
