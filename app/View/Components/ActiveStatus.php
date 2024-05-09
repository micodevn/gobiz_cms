<?php

namespace App\View\Components;

class ActiveStatus extends BaseComponent
{
    public $isActive;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isActive, $id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->isActive = $isActive;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.active-status');
    }
}
