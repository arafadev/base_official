<?php

namespace App\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:permissions,name',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('admin.name'),
        ];
    }
}
