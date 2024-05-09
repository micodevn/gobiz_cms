<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeCurriculumProcessed
{
    use Dispatchable, SerializesModels;

    public $action;
    public $eventName;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action, $eventName, $data)
    {
        $this->action = $action;
        $this->eventName = $eventName;
        $this->data = $data;
    }
}
