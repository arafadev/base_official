<?php
namespace App\Models;
use Illuminate\Support\Carbon;
use App\Services\Sms\SmsService;

class VerificationCode extends BaseModel
{
    protected $table       = 'verification_codes';

    const searchAttributes = ['country_code', 'phone'];

    protected $fillable    = ['phone', 'country_code', 'code', 'verified', 'code_expire', 'type'];

    public function sendVerificationCode()
    {
        $this->update([
            'code'        => $this->activationCode(),
            'code_expire' => Carbon::now()->addMinutes(5),
        ]);
        $this->sendCodeAtSms($this->code);
        return ['user' => $this];
    }

    private function activationCode()
    {
        return 1234;
        return mt_rand(1111, 9999);
    }

    public function sendCodeAtSms($code, $full_phone = null)
    {
        (new SmsService())->sendSms($full_phone ?? $this->full_phone, trans('api.activeCode') . $code);
    }
}
