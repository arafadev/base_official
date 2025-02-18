<?php

namespace  App\Services;

use App\Traits\ResponseTrait;
use App\Enums\WalletTransaction;
use App\Enums\PaymentTransactions;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentGateway\PaymentService;

class WalletService {
    
    use ResponseTrait;
    /**
     * Charge the user's wallet online.
     *
     * @param  array  $request The request data.
     * @param  User   $user    The user object.
     * @return mixed           The response data.
    */
    public function chargeWalletOnline($request, $user)
    {
        // Create a new instance of the PaymentService class
        $paymentService = new PaymentService();

        // Create the payment
        $payment = $paymentService->create()->createPayment($request, $user);

        // Create the payment transaction
        $transaction = $paymentService->createPaymentTransaction(
            $request['amount'],
            PaymentTransactions::CHARGEWALLET,
            'App\Models\Wallet',
            $user->wallet->id,
            $payment['transaction_id'],
            $payment['paymentResponse'],
            $payment['payment_name']
        );
        // Check if the request is an API request
        if (request()->is('api/*')) {
            return $this->successData([
                'redirect_url' => $payment['redirect_url']
            ]);
        } else {
            return redirect()->to($payment['redirect_url']);
        }
    }


    function charge($wallet , $balance) {
        $wallet->update([
            'balance' =>  $wallet->balance + $balance,
            'available_balance' => $wallet->available_balance + $balance,
        ]);

        $wallet->transactions()->create([
            'type'   => WalletTransaction::CHARGE,
            'amount' => $balance
        ]);
        
        $wallet->walletable->update([
            'wallet_balance' =>  $wallet->walletable->wallet_balance + $balance,
        ]);
        
        return $this->successData([
            'balance'           => (float) $wallet->balance ,
            'available_balance' => (float) $wallet->available_balance,
            'pending_balance'   => (float) $wallet->pending_balance ,
        ]);
    }

    function debt($wallet , $balance) 
    {
        
        DB::beginTransaction();
        try{
            $wallet->update([
                'balance' =>  DB::raw('balance - '.$balance),
                'available_balance' =>  DB::raw('available_balance - '.$balance),
            ]);

            $wallet->transactions()->create([
                'type'   => WalletTransaction::DEBT,
                'amount' => $balance
            ]);
            DB::commit();
            return ['key' => 'success', 'msg' => __('apis.success')];
    
        }catch (\Exception $e){
            DB::rollBack();
            log_error($e);
            return ['key' => 'fail', 'msg' => $e->getMessage()] ;
        }
    }


    


}
