<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends BaseModel
{
    use HasFactory;
    
    const IMAGEPATH = 'countries';

    protected $fillable = ['name', 'country_code', 'image', 'iso2', 'iso3'];
}
