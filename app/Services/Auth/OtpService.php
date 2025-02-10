<?php
namespace App\Services\Auth;
use App\Models\User;
use App\Traits\ResponseTrait;
use App\Models\VerificationCode;

class OtpService
{
    use ResponseTrait;

    public function sendOtpCode($request)
    {

        $user = User::where('phone', $request['phone'])
        ->where('country_code', $request['country_code'])
        ->first();


        if ($user && $user->is_blocked) {
            return $this->response('error', __('auth.blocked'));
        }

        $data = [
            'phone'        => $request['phone'],
            'country_code' => $request['country_code'],
            'type'         => 'user',
        ];
        
        $verificationCode = VerificationCode::updateOrCreate($data, $data);
        $verificationCode->sendVerificationCode();
        return $verificationCode->refresh();
    }
}