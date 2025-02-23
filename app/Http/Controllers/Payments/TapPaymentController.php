<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Payments\PaymobService;
use App\Services\Payments\TapService;

class TapPaymentController extends Controller
{

    public function __construct(protected TapService $paymentGateway) {}


    public function paymentProcess(Request $request)
    {

        return $this->paymentGateway->sendPayment($request);
    }

    public function callBack(Request $request): \Illuminate\Http\RedirectResponse
    {

        $response = $this->paymentGateway->callBack($request);  // return true | false

        if ($response) {
            return redirect()->route('payment.success', [
                'status'         => 'success',
                'transaction_id' => $request->tap_id,
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

        return view('payments.success', ['status'   => $request->status ,  'transaction_id' => $request->transaction_id]);
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
