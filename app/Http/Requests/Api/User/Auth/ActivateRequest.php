<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Models\User;
use App\Traits\GeneralTrait;
use App\Http\Requests\Api\BaseApiRequest;

class ActivateRequest extends BaseApiRequest {
  use GeneralTrait;

  public function rules() {
    return [
      'code'         => 'required|max:10',
      'country_code' => 'required|numeric|digits_between:1,5',
      'phone'        => 'required|numeric|digits_between:9,10|exists:users,phone,deleted_at,NULL',
      'device_id'    => 'required|max:250',
      'device_type'  => 'in:ios,android,web',
    ];
  }

  public function prepareForValidation()
  {
    $this->merge([
      'phone' => fixPhone($this->phone),
      'country_code' => fixPhone($this->country_code),
    ]);
  }

  public function withValidator($validator){
    $validator->after(function ($validator) {
      
      $user = User::where(['phone' => $this->phone, 'country_code' => $this->country_code])->first()  ;

      if (!$user) {
        $validator->errors()->add('not_user', trans('auth.failed'));
      }

      if (!$this->isCodeCorrect($user, $this->code)) {
        $validator->errors()->add('wrong_code', trans('auth.code_invalid'));
      }

    });
  }

}
