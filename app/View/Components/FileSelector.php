<?php

namespace App\View\Components;

class FileSelector extends BaseComponent
{
    public $type = 'all';
    public $selected = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'all', $selected = null, $id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->type = $type;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.file-selector');
    }
}
