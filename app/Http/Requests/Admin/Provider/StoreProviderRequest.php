<?php

namespace App\Http\Requests\Admin\Provider;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends BaseRequest
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
            'email'     => 'required|unique:admins,email',
            'password'  => 'required',
            'avatar'    => 'nullable|image|mimes:' . $this->mimesImage(), 
            'is_active' => 'nullable|boolean',
            'is_approved' => 'nullable|boolean',
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
            'is_active'        =>  __('admin.is_active'),
            'is_approved'        => __('admin.is_approved'),
            'is_blocked'        => __('admin.is_blocked'),
        ];
    }
}
