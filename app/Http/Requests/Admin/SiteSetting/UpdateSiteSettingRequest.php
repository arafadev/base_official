<?php

namespace App\Http\Requests\Admin\SiteSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'nullable|string',
            'name_en' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'whatsapp' => 'nullable|numeric',
            'address' => 'nullable|string',
            'vat'   => 'nullable|numeric',
            'admin_percentage'   => 'nullable|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'name.ar' => __('admin.name'),
            'name.en' => __('admin.name'),
            'phone' => __('admin.phone'),
            'whatsapp' => __('admin.whatsapp'),
            'address' => __('admin.address'),
            'vat' => __('admin.vat'),
            'admin_percentage' => __('admin.admin_percentage'),
        ];
    }
}
