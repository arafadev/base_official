<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\AuthBaseModel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
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

}
