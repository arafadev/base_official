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


    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        } 
    }

    public function setAvatarAttribute($value)
    {
        if (!empty($value) && is_file($value)) {
            if (isset($this->attributes['avatar'])) {
                $this->deleteFile($this->attributes['avatar'], static::IMAGEPATH);
            }
            $this->attributes['avatar'] = $this->uploadAllTyps($value, static::IMAGEPATH);
        }
    }

    public function getAvatarAttribute()
    {
        if (!empty($this->attributes['avatar'])) {
            return $this->getImage($this->attributes['avatar'], static::IMAGEPATH);
        }
        return $this->defaultImage(static::IMAGEPATH);
    }

    protected static function boot()
    {
        parent::boot();
        static::bootImageHandlingTrait();

    }
}
