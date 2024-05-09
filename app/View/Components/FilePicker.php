<?php

namespace App\View\Components;

class FilePicker extends BaseComponent
{
    public $name = '';
    public $url = '';
    public $type = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $url = '', $type= '', $id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->name = $name;
        $this->url = $url;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.file-picker');
    }
}
