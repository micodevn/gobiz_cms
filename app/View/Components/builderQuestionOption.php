<?php

namespace App\View\Components;

use Illuminate\View\Component;

class builderQuestionOption extends BaseComponent
{
    public $attributeOptions = null;
    public $attributeParent = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $class = '',$attributeOptions = null,$attributeParent = null)
    {
        parent::__construct($id, $class);
        $this->attributeOptions = $attributeOptions;
        $this->attributeParent = $attributeParent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.builder-question-option');
    }
}
