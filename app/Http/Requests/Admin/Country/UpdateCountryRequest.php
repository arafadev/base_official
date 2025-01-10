<?php

namespace App\Http\Requests\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country_code' => 'required|string|max:3|unique:countries,country_code',
            'iso2'         => 'nullable|string|max:2|unique:countries,iso2',
            'iso3'         => 'nullable|string|max:3|unique:countries,iso3',
        ];
    }
}
