<?php

namespace App\View\Components;

class FilePreview extends BaseComponent
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
        return view('components.file-preview');
    }
}
