<?php

namespace App\Http\Requests\Policy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $areaId = $this->route('id'); 
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('policies', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($areaId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên chính sách',
            'name.string' => 'Tên chính sách phải là dạng ký tự',
            'name.max' => 'Tên chính sách không được vượt quá 255 ký tự',
            'name.unique' => 'Tên chính sách ":input" đã tồn tại trong hệ thống',
        ];
    }
}