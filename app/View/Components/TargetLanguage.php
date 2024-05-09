<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TargetLanguage extends BaseComponent
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.target-language');
    }
}
