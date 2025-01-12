<?php

namespace App\Http\Requests\Admin\Region;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
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
            'country_id'  => 'required|exists:countries,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'name.ar' => __('admin.name'),
            'name.en' => __('admin.name'),
            'country_id' => __('admin.country_id'),
        ];
    }
}
