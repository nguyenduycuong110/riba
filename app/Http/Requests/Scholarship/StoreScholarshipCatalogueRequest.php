<?php

namespace App\Http\Requests\Scholarship;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScholarshipCatalogueRequest extends FormRequest
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
                Rule::unique('scholarship_catalogues', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên nhóm học bổng',
            'name.array' => 'Dữ liệu không hợp lệ',
            'name.min' => 'Phải có ít nhất một nhóm học bổng',
            'name.*.required' => 'Tên nhóm học bổng không được để trống',
            'name.*.string' => 'Tên nhóm học bổng phải là dạng ký tự',
            'name.*.max' => 'Tên nhóm học bổng không được vượt quá 255 ký tự',
            'name.*.unique' => 'Tên nhóm học bổng ":input" đã tồn tại trong hệ thống',
        ];
    }
}