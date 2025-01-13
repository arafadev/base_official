<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ImageHandlingTrait;
use App\Traits\UploadTrait;

class BaseModel extends Model
{
    use UploadTrait, ImageHandlingTrait;

    protected static function boot()
    {
        parent::boot();
        static::bootImageHandlingTrait();
    }
} 