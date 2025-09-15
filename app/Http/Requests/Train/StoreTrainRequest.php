<?php

namespace App\Http\Requests\Train;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTrainRequest extends FormRequest
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
                Rule::unique('trains', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên thể loại đào tạo',
            'name.array' => 'Dữ liệu không hợp lệ',
            'name.min' => 'Phải có ít nhất một thể loại đào tạo',
            'name.*.required' => 'Tên thể loại đào tạo không được để trống',
            'name.*.string' => 'Tên thể loại đào tạo phải là dạng ký tự',
            'name.*.max' => 'Tên thể loại đào tạo không được vượt quá 255 ký tự',
            'name.*.unique' => 'Tên thể loại đào tạo ":input" đã tồn tại trong hệ thống',
        ];
    }
}