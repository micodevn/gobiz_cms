<?php

namespace App\View\Components;

class ApiSelect extends BaseComponent
{
    public $url;
    public $name;
    public $labelField = 'name';
    public $valueField = 'id';
    public $selected = '';
    public $emptyValue = '';
    public $placeholder = null;
    public $paramsFilterDefault = [];
    public $fieldSourceAttribute = null;
    public $emptyInput = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $url = '', $name = '', $labelField = 'name', $valueField = 'id', $selected = [], $emptyValue = '',
        $id = '', $class = '', $attributes = [], $placeholder = null, $paramsFilterDefault = [], $fieldSourceAttribute = null, $emptyInput = true
    )
    {
        parent::__construct($id, $class, $attributes);
        $this->url = $url;
        $this->labelField = empty($labelField) ? 'name' : $labelField;
        $this->valueField = empty($valueField) ? 'id' : $valueField;
        $this->selected = $selected;
        $this->name = $name;
        $this->emptyValue = $emptyValue;
        $this->placeholder = $placeholder;
        $this->paramsFilterDefault = $paramsFilterDefault;
        $this->fieldSourceAttribute = $fieldSourceAttribute;
        $this->emptyInput = $emptyInput;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.api-select');
    }
}
