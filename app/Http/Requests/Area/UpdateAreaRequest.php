<?php

namespace App\Http\Requests\Area;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAreaRequest extends FormRequest
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
                Rule::unique('areas', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($areaId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên trường',
            'name.string' => 'Tên trường phải là dạng ký tự',
            'name.max' => 'Tên trường không được vượt quá 255 ký tự',
            'name.unique' => 'Tên trường ":input" đã tồn tại trong hệ thống',
        ];
    }
}