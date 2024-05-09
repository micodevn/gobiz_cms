<?php

namespace Modules\Province\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => 'required',
            'type'       => 'required',
            'code'       => 'required|integer|unique:districts',
            'province_code'       => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Tên không thể để trống',
            'type.required'       => 'Loại quận/huyện không hợp lệ',
            'code.required'       => 'Mã quận/huyện không thể để trống',
            'code.integer'       => 'Mã quận/huyện không hợp lệ',
            'code.unique'       => 'Mã quận/huyện đã tồn tại',
            'province_code.required'       => 'Tỉnh/thành là bắt buộc',
        ];
    }
}
