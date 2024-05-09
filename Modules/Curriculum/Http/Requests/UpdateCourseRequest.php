<?php

namespace Modules\Curriculum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Curriculum\Entities\Level;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'code' => 'required|string|max:100',
            'level' => 'nullable',
            'thumbnail' => 'nullable',
            'is_active' => 'required|boolean',
        ];
    }
}
