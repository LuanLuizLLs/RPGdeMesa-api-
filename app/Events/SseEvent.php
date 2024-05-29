<?php

namespace App\Events;

class SseEvent extends Event
{
    public $event;
    public $data;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event, $data)
    {
        $this->event = $event;
        $this->data = json_encode($data);
    }
}
