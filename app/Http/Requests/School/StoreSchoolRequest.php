<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:191',
            'name' => 'required|string',
            'code' => 'required|unique:schools',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.email' => 'Email chưa đúng định dạng. Ví dụ: abc@gmail.com',
            'code.required' => 'Bạn chưa nhập vào mã trường.',
            'code.unique' => 'Mã trường đã tồn tại. Hãy chọn lại mã',
            'email.string' => 'Email phải là dạng ký tự',
            'email.max' => 'Độ dài email tối đa 191 ký tự',
            'name.required' => 'Bạn chưa nhập tên trường',
            'name.string' => 'Tên trường phải là dạng ký tự',
        ];
    }
}
