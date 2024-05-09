<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectNormal extends BaseComponent
{

    public $name;
    public $options = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name = '', $options = [],
        $id = '', $class = ''
    )
    {
        parent::__construct($id, $class);
        $this->name = $name;
        $this->options = $options;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-normal');
    }
}
