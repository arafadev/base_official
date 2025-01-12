<?php

namespace App\Http\Requests\Admin\Provider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string',
            'country_code'  => 'required|exists:countries,country_code',
            'phone'     => 'required|unique:admins,phone,' . $this->id ,
            'email'     => 'required|unique:admins,email,' . $this->id ,
            'password' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
            'is_active' => 'nullable|boolean',
            'is_notify' => 'nullable|boolean',
            'is_blocked' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'         => __('admin.name'),
            'country_code' => __('admin.country_code'),
            'phone'        => __('admin.phone'),
            'email'        => __('admin.email'),
            'password'     => __('admin.password'),
            'image'        => __('admin.image'),
            'is_active'    => __('admin.is_active'),
            'is_blocked'   => __('admin.image'),
            'is_notify'   => __('admin.is_notify'),
        ];
    }
}
