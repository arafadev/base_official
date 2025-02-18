<?php

namespace App\Models;

use App\Models\AuthBaseModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class Admin extends AuthBaseModel
{
    use  HasRoles;

    const IMAGEPATH = 'admins';

    protected $fillable = ['country_code', 'role_id', 'email', 'name', 'phone', 'avatar', 'is_blocked', 'is_notify', 'status', 'password'];
  
    public function getFullPhoneAttribute()
    {
        return $this->attributes['country_code'] . $this->attributes['phone'];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::deleted(function ($model) {
    //         if (isset($model->attributes['avatar'])) {
    //             $model->deleteFile($model->attributes['avatar'], static::IMAGEPATH);
    //         }
    //     });
    // }
}
