<?php

namespace Modules\Curriculum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Curriculum\Entities\Activity;

class CreateActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = Activity::$rules;
//        $rule['exercise_id'] = 'nullable';
        return $rule;
    }
}
