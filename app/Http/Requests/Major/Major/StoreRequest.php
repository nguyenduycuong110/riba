<?php

namespace App\Http\Requests\Major\Major;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'name' => 'required',
            'major_catalogue_id' => 'required|exists:major_catalogues,id',
            'train_id' => 'gt:0',
            'canonical' => 'required|unique:routers',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào ô tiêu đề.',
            'major_catalogue_id.required' => 'Bạn chưa chọn ngành.',
            'major_catalogue_id.exists' => 'Ngành bạn chọn không tồn tại.',
            'train_id.gt' => 'Bạn chưa chọn hệ đào tạo.',
            'canonical.required' => 'Bạn chưa nhập vào ô đường dẫn',
            'canonical.unique' => 'Đường dẫn đã tồn tại, Hãy chọn đường dẫn khác',
        ];
    }
}
