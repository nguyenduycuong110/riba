<?php

namespace App\Http\Requests\Policy;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|array|min:1',
            'name.*' => [
                'required',
                'string',
                'max:255',
                Rule::unique('policies', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên chính sách',
            'name.array' => 'Dữ liệu không hợp lệ',
            'name.min' => 'Phải có ít nhất một chính sách',
            'name.*.required' => 'Tên chính sách không được để trống',
            'name.*.string' => 'Tên chính sách phải là dạng ký tự',
            'name.*.max' => 'Tên chính sách không được vượt quá 255 ký tự',
            'name.*.unique' => 'Tên chính sách ":input" đã tồn tại trong hệ thống',
        ];
    }
}