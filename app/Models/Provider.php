<?php

namespace App\Models;

use App\Models\AuthBaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends AuthBaseModel
{

    const IMAGEPATH ='providers';
    
    protected $fillable = 
    [
        'name',
        'email',
        'phone',
        'password',
        'country_code',
        'avatar',
        'is_active',
        'is_blocked',
        'is_approved',
        'code',
        'code_expire'
    ];

    
}
