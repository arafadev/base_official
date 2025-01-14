<?php

namespace App\Models;

use App\Traits\UploadTrait;
use App\Models\AuthBaseModel;
use App\Enums\ProviderApproved;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ImageHandlingTrait;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use Notifiable, UploadTrait , HasRoles,  HasApiTokens, HasFactory, SoftDeletes;

  const IMAGEPATH = 'admins';

  protected $fillable = ['country_code','role_id', 'email', 'name', 'phone', 'avatar', 'is_blocked', 'is_notify', 'status', 'password'];

  protected $hidden = [
    'password',
    'remember_token',
];
protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_notify'  => 'boolean',
    'is_blocked' => 'boolean',
];

public function getFullPhoneAttribute()
{
    return $this->attributes['country_code'] . $this->attributes['phone'];
}



public function role(){
  return $this->belongsTo(Role::class);
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
public function getApprovedIconAttribute()
{
switch ($this->attributes['is_approved']) {
    case ProviderApproved::PENDING: 
        return '<i class="fe fe-clock" style="color: #f1c40f; font-size: 18px;"></i>';
    case ProviderApproved::ACCEPTED: 
        return '<i class="fe fe-thumbs-up" style="color: #2ecc71; font-size: 18px;"></i>'; 
    case ProviderApproved::REJECTED: 
        return '<i class="fe fe-thumbs-down" style="color: #e74c3c; font-size: 18px;"></i>'; 
    default:
        return '<i class="fe fe-alert-triangle" style="color: #e67e22; font-size: 18px;"></i>'; 
}
}


public function getBlockedIconAttribute()
{
if ($this->attributes['is_blocked']) {
    return '<i class="fe fe-slash" style="color: #e74c3c; font-size: 18px;"></i>'; 
}
return '<i class="fe fe-check" style="color: #2ecc71; font-size: 18px;"></i>'; 
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
    static::deleted(function ($model) {
        if (isset($model->attributes['avatar'])) {
            dd('not enter here ');
            $model->deleteFile($model->attributes['avatar'], static::IMAGEPATH);
        }
    });
}

}
