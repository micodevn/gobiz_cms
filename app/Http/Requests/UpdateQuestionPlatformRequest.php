<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\QuestionPlatform;

class UpdateQuestionPlatformRequest extends FormRequest
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
        $id = intval($this->questionPlatform);
        $rules = QuestionPlatform::$rules;
        $rules['parent_id'] =
            function ($attribute, $value, $fail) use ($id) {
                if ($value == $id) {
                    $fail('The cannot use this platform as ' . $attribute);
                }
            };

        return $rules;
    }
}
