<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Payments\AlRajhiService;
use App\Services\Payments\StripePaymentService;

class AlrajhiPaymentController extends Controller
{

    public function __construct(protected AlRajhiService $paymentGateway) {}


    public function paymentProcess(Request $request)
    {

        $response = $this->paymentGateway->sendPayment($request);

        if ($request->is('api/*')) {
            return response()->json($response,200);
        }

        return redirect($response['url']);
    }

    public function callBack(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = $this->paymentGateway->callBack($request);

        if ($response) {
            return redirect()->route('payment.success', [
                'status'         => 'success',
                'transaction_id' => $request->paymentid,
                'msg'            => __('apis.payment_success')
            ]);
        }
        return redirect()->route('payment.failed');
    }


    public function success(Request $request)
    {

        $status = in_array($request->status, [
            'success',
            'failed',
        ]) ? $request->status : 'failed';

        // 👇👇 write your logic here (check transaction status here and update it in database , send email, notify user, etc...)👇👇

        return view('payments.success', ['status'   => $request->status,  'transaction_id' => $request->transaction_id]);
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
