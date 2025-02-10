<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class PreSendCode extends BaseApiRequest
{
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
            'phone'        => 'required|numeric',
            'country_code' => 'required|numeric|digits_between:1,5',
            'iso'          => 'required|exists:countries,iso2',
            'device_id'   => 'required|string',
			'device_type' => 'required|string',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([ 
            'country_code' => fixPhone( $this->country_code ),
            'phone'        => fixPhone( $this->phone ),
            'iso'          => strtoupper( $this->iso )
        ]);
    }
}
