<?php

namespace App\Http\Controllers\Payments;

use App\Interfaces\Payments\PaymentGatewayInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    protected PaymentGatewayInterface $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function paymentProcess(Request $request)
    {
        $response = $this->paymentGateway->sendPayment($request);

        if ($request->is('api/*')) {
            return response()->json($response, 200);
        }

        return redirect($response['url']);
    }

    public function callBack(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = $this->paymentGateway->callBack($request); 
        

        if (is_array($response) && isset($response['status']) && $response['status'] === true ) {
            $transaction_id = $response['transaction_id'] ?? $request->get('id'); 
            return redirect()->route('payment.success', [
                'status'         => 'success',
                'transaction_id' => $transaction_id,
                'msg'            => __('apis.payment_success')
            ]);
        } elseif ($response === true) {
            return redirect()->route('payment.success', [
                'status'         => 'success',
                'transaction_id' => $request->get('id'),
                'msg'            => __('apis.payment_success')
            ]);
        }
        return redirect()->route('payment.failed');
    }

    public function success(Request $request)
    {
        $status = in_array($request->status, ['success', 'failed']) ? $request->status : 'failed';

        return view('payments.success', [
            'status'         => $status,
            'transaction_id' => $request->transaction_id,
        ]);
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
