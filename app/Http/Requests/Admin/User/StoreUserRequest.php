<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends BaseRequest
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
            'avatar' => 'nullable|image|mimes:' . $this->mimesImage(), 
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
            'is_active'        => __('admin.is_active'),
            'is_blocked'        => __('admin.is_blocked'),
            'is_notify'        => __('admin.is_notify'),
        ];
    }
}
