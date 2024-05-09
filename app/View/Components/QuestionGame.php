<?php

namespace App\View\Components;

use App\Models\LiveClass;
use App\Models\Question;
use Illuminate\View\Component;

class QuestionGame extends BaseComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $liveClass;
    public $questions;
    public function __construct($liveClass = null,$questions = null, $id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->liveClass = $liveClass ?? new LiveClass();
        $this->questions = $questions ?? new Question();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.questions-game');
    }
}
