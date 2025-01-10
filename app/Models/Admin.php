<?php

namespace App\Models;

use App\Models\AuthBaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends AuthBaseModel
{
  use HasFactory;

  const IMAGEPATH = 'admins';

  protected $fillable = ['country_code', 'email', 'name', 'phone', 'avatar', 'is_blocked', 'is_notify', 'status', 'password'];


}
