<?php

namespace App\Listeners;

use App\Events\ChangeCurriculumProcessed;
use Illuminate\Support\Facades\Redis;

class SyncSystemDataCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ChangeCurriculumProcessed $event
     * @return void
     */
    public function handle(ChangeCurriculumProcessed $event)
    {
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => $event->action,
            'eventName' => $event->eventName,
            'data' => $event->data
        ]));
    }
}
