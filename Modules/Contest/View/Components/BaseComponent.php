<?php

namespace Modules\Contest\View\Components;

use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

abstract class BaseComponent extends Component
{
    public $id;
    public $class;
    public $inlineAttributes = '';
    public $attributes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $class = '', $attributes = [])
    {
        $this->attributes = new ComponentAttributeBag($attributes);
        $this->id = $id;
        $this->class = $class;
        $this->inlineAttributes = $this->attributes->toHtml();
    }
}
