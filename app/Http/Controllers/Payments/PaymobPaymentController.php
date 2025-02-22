<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Payments\PaymobService;

class PaymobPaymentController extends Controller
{

    public function __construct(protected PaymobService $paymentGateway) {}


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
                'transaction_id' => $request->order,
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

        return view('payments.success', ['status'   => $request->status ,  'transaction_id' => $request->transaction_id]);
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
