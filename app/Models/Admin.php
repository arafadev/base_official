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


class Admin extends AuthBaseModel
{
    use Notifiable, UploadTrait, HasRoles,  HasApiTokens, HasFactory, SoftDeletes;

    const IMAGEPATH = 'admins';

    protected $fillable = ['country_code', 'role_id', 'email', 'name', 'phone', 'avatar', 'is_blocked', 'is_notify', 'status', 'password'];

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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function getBlockedIconAttribute()
    {
        $url = route('admin.admins.toggle', ['id' => $this->id, 'field' => 'is_blocked']);
        if ($this->attributes['is_blocked']) {
            return '<a href="' . $url . '" style="text-decoration: none;">
                        <i class="fe fe-slash" style="color: #e74c3c; font-size: 18px;"></i>
                    </a>';
        }
        return '<a href="' . $url . '" style="text-decoration: none;">
                    <i class="fe fe-check" style="color: #2ecc71; font-size: 18px;"></i>
                </a>';
    }
    
    public function getNotifyIconAttribute()
    {
        $url = route('admin.admins.toggle', ['id' => $this->id, 'field' => 'is_notify']);
        if ($this->attributes['is_notify']) {
            return '<a href="' . $url . '" style="text-decoration: none;">
                        <i class="fe fe-bell" style="color: #2ecc71; font-size: 18px;"></i>
                    </a>';
        }
        return '<a href="' . $url . '" style="text-decoration: none;">
                    <i class="fe fe-bell-off" style="color: #e74c3c; font-size: 18px;"></i>
                </a>';
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
