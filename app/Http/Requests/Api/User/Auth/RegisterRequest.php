<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class RegisterRequest extends BaseApiRequest
{

  public function rules()
  {
    return [
      'name'          => 'required|max:50',
      'phone'               => 'required|numeric|unique:users,phone,NULL,id,deleted_at,NULL',
      'country_code'        => 'required|numeric|digits_between:2,5',
      'email'               => 'required|email|unique:users,email,NULL,id,deleted_at,NULL|max:50',
      // 'avatar'              => 'nullable|mimes:' . $this->mimesImage(),
      'lang'                => 'required|in:ar,en',
      'device_type'         => 'required|in:android,ios,web',
      'device_id'           => 'required',
    ];
  }

  public function prepareForValidation()
  {
    $this->merge([
      'phone' => fixPhone($this->phone),
      'country_code' => fixPhone($this->country_code),
    ]);
  }
}
