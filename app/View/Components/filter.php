<?php

namespace App\View\Components;

use Illuminate\View\Component;

class filter extends BaseComponent
{

    public $filterAble = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filterAble = [],$id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->filterAble = $filterAble;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filter');
    }
}
