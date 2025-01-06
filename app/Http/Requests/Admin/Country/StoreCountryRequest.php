<?php

namespace App\Http\Requests\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'         => 'required|string|max:255|unique:countries,name',
            'country_code' => 'required|string|max:3|unique:countries,country_code',
            'iso2'         => 'required|string|max:2|unique:countries,iso2',
            'iso3'         => 'required|string|max:3|unique:countries,iso3',
        ];
    }
}
