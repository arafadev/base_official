<?php

namespace App\Http\Requests\Api\User\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Traits\ResponseTrait;
use App\Models\VerificationCode;
use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CodeRequest extends BaseApiRequest
{
    use ResponseTrait, GeneralTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'         => 'required|max:10',
            'country_code' => 'required|numeric|digits_between:1,5',
            // 'phone'     => 'required|exists:users,phone|numeric|phone:' . $this->iso,
            'phone'        => 'required|numeric|exists:users,phone,deleted_at,NULL',
            'iso'          => 'required|exists:countries,iso2',
            'device_type'  => 'required|in:web,android,ios',
            'device_id'    => 'required',
            'lang'         => 'required|in:ar,en',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code),
            'iso'          => strtoupper($this->iso)
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        $codeCheck = isset($this->code) ? VerificationCode::where('phone', $this->phone)
            ->where('code', $this->code)
            ->where('code_expire', '>=', Carbon::parse(Carbon::now()))
            ->first() : null;

        if ($codeCheck) {
            $codeCheck->update(['verified' => true]);
            $response = $this->response('not_exist', __('auth.verified_successfully'));
        } else {
            $response = $this->response('exception', 'auth.Invalid_code');
        }

        throw new HttpResponseException($response);
    }

    protected function passedValidation()
    {

        parent::passedValidation();

        $verificationCode = VerificationCode::where('phone', $this->phone)->where('code', $this->code)->first();

        if (!User::where(['phone' => $this->phone, 'country_code' => $this->country_code])->first()) {
            $verificationCode->update(['verified' => true]);
            $response = $this->response('not_exist', __('auth.verified_successfully'));
            throw new HttpResponseException($response);
        }

        if (!$verificationCode || !$this->isCodeCorrect($verificationCode, $this->code)) {
            throw new HttpResponseException($this->response('wrong_code', __('auth.Invalid_code')));
        }
    }
}
