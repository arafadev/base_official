<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleHasPermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',  
            'permissions.*' => 'exists:permissions,id', 
        ];
    }

    public function attributes(): array
    {
        return [
            'role_id.required' => 'الدور مطلوب',
            'role_id.exists' => 'الدور المحدد غير موجود',
            'permissions.required' => 'يجب تحديد على الأقل إذن واحد',
            'permissions.array' => 'الأذونات يجب أن تكون مصفوفة',
            'permissions.*.exists' => 'إذن واحد أو أكثر غير موجود في النظام',
        ];
    }
}
