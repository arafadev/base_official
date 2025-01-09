<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


function langsWithLabels(){
    return [
        'ar' => __('admin.arabic'),
        'en' => __('admin.english'),
    ];
}


function lang(){
    return LaravelLocalization::getCurrentLocale();
}
function languages()
{
    return ['ar', 'en'];
}
