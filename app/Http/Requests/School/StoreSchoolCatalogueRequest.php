<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSchoolCatalogueRequest extends FormRequest
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
                Rule::unique('school_catalogues', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên thể loại hình trường',
            'name.array' => 'Dữ liệu không hợp lệ',
            'name.min' => 'Phải có ít nhất một thể loại hình trường',
            'name.*.required' => 'Tên thể loại hình trường không được để trống',
            'name.*.string' => 'Tên thể loại hình trường phải là dạng ký tự',
            'name.*.max' => 'Tên thể loại hình trường không được vượt quá 255 ký tự',
            'name.*.unique' => 'Tên thể loại hình trường ":input" đã tồn tại trong hệ thống',
        ];
    }
}