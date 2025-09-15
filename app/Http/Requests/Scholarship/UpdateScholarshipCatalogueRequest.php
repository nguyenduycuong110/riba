<?php

namespace App\Http\Requests\Scholarship;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateScholarshipCatalogueRequest extends FormRequest
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
                Rule::unique('scholarship_catalogues', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($areaId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên nhóm học bổng',
            'name.string' => 'Tên nhóm học bổng phải là dạng ký tự',
            'name.max' => 'Tên nhóm học bổng không được vượt quá 255 ký tự',
            'name.unique' => 'Tên nhóm học bổng ":input" đã tồn tại trong hệ thống',
        ];
    }
}