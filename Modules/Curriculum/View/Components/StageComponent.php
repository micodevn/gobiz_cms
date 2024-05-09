<?php

namespace Modules\Curriculum\View\Components;

use Illuminate\View\Component;

class StageComponent extends Component
{
    protected $contest;
    protected $selectedRounds;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($course = null, $selectedRounds = null)
    {
        $this->course = $course ?? null;
        $this->selectedRounds = $selectedRounds ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('curriculum::pages.courses.stage-component', [
            'course' => $this->course
        ]);
    }
}
