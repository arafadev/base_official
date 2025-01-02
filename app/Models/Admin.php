<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['country_code', 'email','name', 'phone', 'avatar' ,'is_blocked','is_notify', 'status', 'password'];

    protected $hidden = [
		'password',
	];
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
];
}
