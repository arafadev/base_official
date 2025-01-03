<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
        'title' => 'required|string',
        'icon' => 'required|string',
        'description' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' =>  __('admin.title'),
            'icon' => __('admin.icon'),
            'description' => __('admin.description'),
        ];
    }
}
