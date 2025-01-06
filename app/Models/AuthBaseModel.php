<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\UploadTrait;
use App\Traits\ImageHandlingTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthBaseModel extends Authenticatable
{
    use Notifiable, UploadTrait ,  ImageHandlingTrait, SoftDeletes;

    const IMAGEPATH = 'users';

    protected $hidden = ['password'];



    protected static function boot()
    {
        parent::boot();
        static::bootImageHandlingTrait();

    }
}
