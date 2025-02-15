<?php 

namespace App\Services\PaymentGateway;

use App\Enums\PayStatus;
use App\Models\Collectible;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use App\Enums\WalletTransaction;
use App\Enums\PaymentTransactions;
use App\Models\PaymentTransaction;
use App\Services\User\PaymentCollectableService;
use App\Notifications\ReservationPaidNotification;

class PaymentService
{
    /**
     * Factory method to create a payment service instance.
     *
     * @return MyfatoorahService|HyperpayService|ClickpayService|AlrajhibankService|
     *         PaymobService|PaypalService|StripeService|TelrService
    */
    public static function create()
    {
        // Uncomment the line corresponding to the desired payment service.
        return new MyfatoorahService;
        // return new HyperpayService ;
        // return new ClickpayService ; 
        // return new AlrajhibankService ; 
        // return new PaymobService ; 
        // return new PaypalService ; 
        // return new StripeService ; 
        // return new TelrService ; 
    }

    function createPaymentTransaction($amount,$type , $transactionable_type , $transactionable_id , $transaction_id , $payemtResponse ,$paymentName, $data = [] ) {

        PaymentTransaction::create([
            'amount'           => $amount ,
            'type'             => $type,
            'trans_type'       => $transactionable_type,
            'trans_id'         => $transactionable_id ,
            'transaction_id'   => $transaction_id,
            'getaway_response' => $payemtResponse,
            'payment_getaway'  => $paymentName,
            'currency_code'    => 'SAR',
            'status'           => 'pending',
            'data'              => $data
        ]);
    }


    /**
     * This function handles the callback from the payment service.
     * It uses the appropriate service class based on the payment service used.
     *
     * @param Request $request The request object containing paymentId
     * @return mixed The result of the checkPayment function
    */
    public static function callback(Request $request , $brand_id = null)
    {

        // dd($request);
        
        // Select the appropriate service class based on the payment service used
       $serviceClass = new MyfatoorahService();
        // $serviceClass = new HyperpayService() ;
        // return new ClickpayService ; 
        // return new AlrajhibankService ; 
        // return new PaymobService ; 
        // return new PaypalService ; 
        // return new StripeService ; 
        // return new TelrService ;

        // Get the payment status using the selected service class
        $data = $serviceClass->getPaymentStatus($request->paymentId , $brand_id);
        // Check the payment status and return the result
        return PaymentService::checkPayment($data);
    }


    /**
     * Check the payment status and update the transaction accordingly.
     *
     * @param array $data The payment data.
     * @return \Illuminate\Contracts\View\View The view for the payment status.
    */
    public static function checkPayment($data)
    {
        // Retrieve the payment transaction.
        $transaction = PaymentTransaction::where(
            'transaction_id', $data['transaction_id']
        )->whereStatus('pending')->firstOrFail();

        // If payment status is false, return failed view.
        if ($data['status'] == false) {
            $transaction->update([
                'status' =>  'failed'
            ]);
            return redirect()->route('payment.callbackStatus', [
				'transaction_id' => $data['transaction_id'],
				'status'         => 'failed',
				'msg'            => __('apis.payment_failed')
			]);
        }
        // Update the transaction status.
        $transaction->update([
            'status' => 'completed'
        ]);

        $collectible = $transaction->trans; 
        // $collectible_id = $collectible->id;

    if ($transaction->trans_type === 'App\Models\Reservation') {

        if ($collectible->status === ReservationStatus::NEW || $collectible->status === ReservationStatus::PENDING) {
            $collectible->update([
                'status' => 'current',
                'pay_status' => PayStatus::DONE
            ]);
            $approvedType = $collectible->refresh()->status == ReservationStatus::CURRENT ? ReservationStatus::CURRENT : ReservationStatus::PENDING;
            $collectible->teacher?->notify(new ReservationPaidNotification($approvedType));
        }
    } else {
        $paymentService = new PaymentCollectableService();
        $paymentDetails = $paymentService->getCollectiblePayDetails($collectible);

        Collectible::create([
            'user_id' => $transaction->data['user_id'] ,
            'collectable_type' => get_class($collectible),
            'collectable_id' => $collectible->id,
            'price' => $paymentDetails['original_price'],
            'vat_ratio' => $paymentDetails['vat_ratio'],
            'vat_amount' => $paymentDetails['vat_amount'],
            'admin_percentage' => settings('admin_percentage'),
            'admin_amount' => $paymentDetails['original_price'] * (settings('admin_percentage') / 100),
            'total_amount' => $paymentDetails['total_price'],
            'is_exam' =>$transaction->data['type'] === 'exam' ? 1 : 0,
        ]);
    }

    // Return success view.
    // return view('payment.success', [
    //     'trans_id' => $data['transaction_id'],
    //     'status' => $data['status']
    // ]);

    return redirect()->route('payment.callbackStatus', [
        'transaction_id' => $data['transaction_id'],
        'status'         => 'success',
        'msg'            => __('apis.payment_success')
    ]);
    }

    /**
     * Charge the wallet with a transaction amount.
     *
     * @param  object  $transaction
     * @return void
    */
    static function chargeWallet($transaction) {
        // Get the wallet from the transaction
        $wallet = $transaction->trans; 

        // Update the balance and available balance in the wallet
        $wallet->update([
            'balance'           => $transaction->amount +  $transaction->trans->balance, 
            'available_balance' => $transaction->amount +  $transaction->trans->available_balance, 
        ]);

        $wallet->transactions()->create([
            'type'                  =>  WalletTransaction::CHARGE,
            'transactionable_type'  =>  $transaction->trans_type,
            'transactionable_id'    =>  $transaction->trans_id,
            'amount'                =>  $transaction->amount,
        ]);

        // Return nothing
        return ;
    }

    public function callbackStatus(Request $request, $trans_id)
	{
		$status = in_array($request->status, [
			'success',
			'failed',
		]) ? $request->status : 'failed';
		return view('payment.' . $status, compact('status', 'trans_id'));

	}
}
