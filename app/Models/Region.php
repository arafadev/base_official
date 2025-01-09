<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'country_id'];

    public function setNameAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['name'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            info('The name attribute must be an array with keys for each language.');
            throw new \InvalidArgumentException('The name attribute must be an array with keys for each language.');
        }
    }
    

    public function getNameAttribute($value)
    {
        $names = json_decode($value, true);

        $locale = LaravelLocalization::getCurrentLocale();

        return $names[$locale] ?? $names['en'];
    }

    public function getAllTranslations()
    {
        return json_decode($this->attributes['name'], true);
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    // public function cities()
    // {
    //     return $this->hasMany(City::class, 'region_id', 'id');
    // }
}
