<?php

namespace App\Http\Requests\Area;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAreaRequest extends FormRequest
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
                Rule::unique('areas', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên trường',
            'name.array' => 'Dữ liệu không hợp lệ',
            'name.min' => 'Phải có ít nhất một trường',
            'name.*.required' => 'Tên trường không được để trống',
            'name.*.string' => 'Tên trường phải là dạng ký tự',
            'name.*.max' => 'Tên trường không được vượt quá 255 ký tự',
            'name.*.unique' => 'Tên trường ":input" đã tồn tại trong hệ thống',
        ];
    }
}