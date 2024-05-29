<?php

namespace App\Listeners;

use App\Models\Sse;
use App\Events\SseEvent;
use App\Http\Controllers\SseController;
use Illuminate\Contracts\Queue\ShouldQueue;

class SseListener implements ShouldQueue
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
     * @param  \App\Events\SseEvent  $event
     * @return void
     */
    public function handle(SseEvent $event)
    {
      $sse = new SseController();
      $sse->event($event);
    }
}
