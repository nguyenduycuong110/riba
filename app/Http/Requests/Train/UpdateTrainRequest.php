<?php

namespace App\Http\Requests\Train;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainRequest extends FormRequest
{
    /**
     * Determine if the customer is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập  tên trường',
            'name.string' => 'Tên trường phải là dạng ký tự',
        ];
    }
}
