<?php

namespace Modules\Contest\View\Components;

use Illuminate\View\Component;

class PickRoundComponent extends Component
{
    protected $contest;
    protected $selectedRounds;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($contest = null, $selectedRounds = null)
    {
        $this->contest = $contest ?? null;
        $this->selectedRounds = $selectedRounds ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('contest::components.pick-round-component', [
            'contest' => $this->contest
        ]);
    }
}
