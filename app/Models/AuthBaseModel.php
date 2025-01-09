<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\UploadTrait;
use App\Traits\ImageHandlingTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthBaseModel extends Authenticatable
{
    use Notifiable, UploadTrait ,  ImageHandlingTrait, SoftDeletes;

    const IMAGEPATH = 'users';

    protected $hidden = ['password'];


    
  public function getFullPhoneAttribute()
  {
      return $this->attributes['country_code'] . $this->attributes['phone'];
  }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        } 
    }

    public function setAvatarAttribute($value)
    {
        if (!empty($value) && is_file($value)) {
            if (isset($this->attributes['avatar'])) {
                $this->deleteFile($this->attributes['avatar'], static::IMAGEPATH);
            }
            $this->attributes['avatar'] = $this->uploadAllTyps($value, static::IMAGEPATH);
        }
    }

    public function getAvatarAttribute()
    {
        if (!empty($this->attributes['avatar'])) {
            return $this->getImage($this->attributes['avatar'], static::IMAGEPATH);
        }
        return $this->defaultImage(static::IMAGEPATH);
    }

    
    public function getActiveIconAttribute()
{
    if ($this->attributes['is_active']) {
        return '<i class="fe fe-check-circle" style="color: #2ecc71; font-size: 18px;"></i>';
    }
    return '<i class="fe fe-x-circle" style="color: #e74c3c; font-size: 18px;"></i>';
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

    protected static function boot()
    {
        parent::boot();
        static::bootImageHandlingTrait();

    }
}
