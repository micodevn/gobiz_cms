<?php

namespace Modules\Curriculum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Curriculum\Entities\Level;

class CreateCourseRequest extends FormRequest
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
        return Level::$rules;
    }
}
