<?php

namespace App\Http\Requests\Train;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên trường',
            'name.string' => 'Tên trường phải là dạng ký tự',
        ];
    }
}
