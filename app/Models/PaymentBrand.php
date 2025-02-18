<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class PaymentBrand extends BaseModel
{

    const IMAGEPATH = 'paymentbrands' ; 
    
    protected $fillable = [
        'image',
        'name',
        'type',
        'status',
        'entity_id',
    ];

    
}
