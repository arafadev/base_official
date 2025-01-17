<?php
namespace App\Services\Auth;
use App\Traits\ResponseTrait;
use App\Models\VerificationCode;

class OtpService
{
    use ResponseTrait;

    public function sendOtpCode($request)
    {
        $type = $request->is('*/user/*') ? 'user' : 'provider';
        $data = [
            'phone'        => $request['phone'],
            'country_code' => $request['country_code'],
            'type'         => $type,
        ];
        $verificationCode = VerificationCode::updateOrCreate($data, $data);
        $verificationCode->sendVerificationCode();
        return $verificationCode->refresh();
    }
}