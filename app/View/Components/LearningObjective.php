<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LearningObjective extends BaseComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $class = '')
    {
        parent::__construct($id, $class);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.learning-objective');
    }
}
