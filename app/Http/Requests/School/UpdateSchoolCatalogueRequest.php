<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolCatalogueRequest extends FormRequest
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
                Rule::unique('school_catalogues', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($areaId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên thể loại hình trường',
            'name.string' => 'Tên thể loại hình trường phải là dạng ký tự',
            'name.max' => 'Tên thể loại hình trường không được vượt quá 255 ký tự',
            'name.unique' => 'Tên thể loại hình trường ":input" đã tồn tại trong hệ thống',
        ];
    }
}