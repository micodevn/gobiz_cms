<?php

namespace App\View\Components;

class ImagePicker extends BaseComponent
{
    public $name = false;
    public $url = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $url = null, $id = '', $class = '')
    {
        parent::__construct($id, $class);
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.image-picker');
    }
}
