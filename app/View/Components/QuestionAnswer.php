<?php

namespace App\View\Components;

use App\Models\Question;

class QuestionAnswer extends BaseComponent
{
    public $question;
    public function __construct($question = null, $id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->question = $question ?? new Question();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.question-answer');
    }
}
