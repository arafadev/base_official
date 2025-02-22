<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Payments\PaymentGatewayInterface;

class PaymentController extends Controller
{

    public function __construct(protected PaymentGatewayInterface $paymentGateway) {}


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

    public function success(Request $request, $transaction_id)
    {
        $status = in_array($request->status, [
			'success',
			'failed',
		]) ? $request->status : 'failed';

        return view('payments.success', compact('status', 'transaction_id'));
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
