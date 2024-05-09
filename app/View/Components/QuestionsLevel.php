<?php

namespace App\View\Components;

use App\Models\BaseModel;
use App\Models\Exercise;
use App\Models\ExerciseAttribute;
use Illuminate\View\Component;

class QuestionsLevel extends BaseComponent
{

    public $exercises;
    /**
     * Create a new component instance.
     *
     */
    public function __construct($exercises= null,$id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->exercises = $exercises ?? new Exercise();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.questions-level');
    }
}
