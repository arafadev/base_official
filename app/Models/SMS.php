<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $fillable = ['name','active','sender_name','key' ,'user_name' , 'password'];
}
