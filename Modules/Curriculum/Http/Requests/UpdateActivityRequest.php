<?php

namespace Modules\Curriculum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Curriculum\Entities\Activity;

class UpdateActivityRequest extends FormRequest
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
        $rules = Activity::$rules;

        return $rules;
    }
}
