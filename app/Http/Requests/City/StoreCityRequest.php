<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'area_id' => 'gt:0'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập thành phố',
            'name.string' => 'Tên thành phố phải là dạng ký tự',
        ];
    }
}
