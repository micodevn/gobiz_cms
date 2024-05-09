<?php

namespace App\View\Components;

use App\Models\File;

class VideoProperty extends BaseComponent
{
    public $file;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $class = '', $file = null)
    {
        parent::__construct($id, $class);
        $this->file = $file ?? new File();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.video-property');
    }
}
