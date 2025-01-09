<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Country extends BaseModel
{
    use HasFactory;
    
    const IMAGEPATH = 'countries';

    protected $fillable = ['name', 'country_code', 'image', 'iso2', 'iso3'];

    public function getNameAttribute($value)
    {
        $names = json_decode($value, true);

        $locale = LaravelLocalization::getCurrentLocale();

        return $names[$locale] ?? $names['en'];
    }
    public function setNameAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['name'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            info('The name attribute must be an array with keys for each language.');
            throw new \InvalidArgumentException('The name attribute must be an array with keys for each language.');
        }
    }
}
