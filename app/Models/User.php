<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UploadTrait;
use App\Models\AuthBaseModel;
use App\Enums\ProviderApproved;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends AuthBaseModel
{
    const IMAGEPATH = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'country_code',
        'phone',
        'avatar',
        'is_active',
        'is_blocked',
        'lang',
        'is_notify',
        'code',
        'code_expire',
    ];

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
    
}
