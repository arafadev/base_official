<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'phone'     => 'required|unique:admins,phone|digits_between:7,15',
            'role_id'     => 'required|exists:roles,id',
            'email'     => 'required|unique:admins,email',
            'password'  => 'required',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
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
            'role_id'      => __('admin.role_id'),
            'email'        => __('admin.email'),
            'password'     => __('admin.password'),
            'image'        => __('admin.image'),
        ];
    }
}
