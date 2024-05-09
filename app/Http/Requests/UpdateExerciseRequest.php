<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Exercise;
use League\Config\Exception\ValidationException;

class UpdateExerciseRequest extends FormRequest
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
        //|| !$val['level'] || !$val['question_number']
        $errors = [];
        if (!empty($this->questionsLevel)) {
            foreach ($this->questionsLevel as $val) {
                if (empty($val['level'])) {
//                    $errors['level'] = 'Missing Questions Level';
                }
                if (empty($val['question_number'])) {
                    $errors['question_number'] = 'Missing number of Questions';
                }
            }
            $errors && throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }
        return Exercise::$rules;
        

    }
}
