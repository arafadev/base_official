<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
  private $token               = '';

  public function setToken($value) {
    $this->token = $value;
    return $this;
  }

  public function toArray($request) {

    return [
      'id'                  => $this->id,
      'name'                => $this->name,
      'email'               => $this->email,
      'full_phone'          => $this->full_phone,
      // 'avatar'              => $this->avatar,
      'country_code'        => $this->country_code,
      'lang'                => $this->lang,
      'is_active'           => $this->is_active ,
      'is_notify'           => $this->is_notify,
      'token'               => $this->token,
    ];
  }
}
