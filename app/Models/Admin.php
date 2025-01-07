<?php

namespace App\Models;

use App\Models\AuthBaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends AuthBaseModel
{
  use HasFactory;
  
  const IMAGEPATH = 'admins';

  protected $fillable = ['country_code', 'email', 'name', 'phone', 'avatar', 'is_blocked', 'is_notify', 'status', 'password'];

  protected $hidden = [
    'password',
  ];
  protected $casts = [
    'is_notify'  => 'boolean',
    'is_blocked' => 'boolean',
  ];

  

  public function getFullPhoneAttribute()
  {
      return $this->attributes['country_code'] . $this->attributes['phone'];
  }
  
  public function getBlockedIconAttribute()
  {
      if ($this->attributes['is_blocked']) {
          return '<i class="fe fe-alert-circle" style="color: #e74c3c; font-size: 18px;"></i>'; 
      }
      return '<i class="fe fe-check-circle" style="color: #2ecc71; font-size: 18px;"></i>'; 
  }

  public function getNotifyIconAttribute()
  {
      if ($this->attributes['is_notify']) {
          return '<i class="fe fe-bell" style="color: #2ecc71; font-size: 18px;"></i>';
      }
      return '<i class="fe fe-bell-off" style="color: #e74c3c; font-size: 18px;"></i>'; 
  }
  
  
}
