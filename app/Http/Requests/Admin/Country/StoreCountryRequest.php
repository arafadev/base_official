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
            'name.ar'        => 'required|string',
            'name.en'       => 'required|string',
            'image'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country_code' => 'required|string|max:3|unique:countries,country_code',
            'iso2'         => 'required|string|max:2|unique:countries,iso2',
            'iso3'         => 'required|string|max:3|unique:countries,iso3',
        ];
    }
    public function attributes(): array
    {
        return [
            'name.ar' => __('admin.name'),
            'name.en' => __('admin.name'),
            'image' => __('admin.image'),
            'country_code' => __('admin.country_code'),
            'iso2' => __('admin.iso2'),
            'iso3' => __('admin.iso3'),
        ];
    }
}
