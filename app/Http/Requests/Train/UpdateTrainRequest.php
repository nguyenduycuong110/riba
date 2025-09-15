<?php

namespace App\Http\Requests\Train;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainRequest extends FormRequest
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
                Rule::unique('trains', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($areaId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên thể loại đào tạo',
            'name.string' => 'Tên thể loại đào tạo phải là dạng ký tự',
            'name.max' => 'Tên thể loại đào tạo không được vượt quá 255 ký tự',
            'name.unique' => 'Tên thể loại đào tạo ":input" đã tồn tại trong hệ thống',
        ];
    }
}