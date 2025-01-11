<?php

namespace App\Models;

use App\Models\AuthBaseModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends AuthBaseModel
{
  use HasFactory, HasRoles;

  const IMAGEPATH = 'admins';

  protected $fillable = ['country_code','role_id', 'email', 'name', 'phone', 'avatar', 'is_blocked', 'is_notify', 'status', 'password'];

  public function role(){
    return $this->belongsTo(Role::class);
  }

}
