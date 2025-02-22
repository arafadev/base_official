<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UploadTrait;
use App\Models\AuthBaseModel;
use App\Enums\ProviderApproved;



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

}
