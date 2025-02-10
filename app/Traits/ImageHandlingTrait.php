<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageHandlingTrait
{

    public function setImageAttribute($value)
    {
        if (!empty($value) && is_file($value)) {
            if (isset($this->attributes['image'])) {
                $this->deleteFile($this->attributes['image'], static::IMAGEPATH);
            }
            $this->attributes['image'] = $this->uploadAllTyps($value, static::IMAGEPATH);
        }
    }
    
    public function getImageAttribute()
    {
        if (!empty($this->attributes['image'])) {
            return $this->getImage($this->attributes['image'], static::IMAGEPATH);
        }
        return $this->defaultImage(static::IMAGEPATH);
    }

  

    public static function bootImageHandlingTrait()
    {
        static::deleted(function ($model) {
            if (isset($model->attributes['image'])) {
                $model->deleteFile($model->attributes['image'], static::IMAGEPATH);
            }
        });
    }
}