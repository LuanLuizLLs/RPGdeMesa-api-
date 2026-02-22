<?php

namespace App\Events;

class SseEvent extends Event
{
    public $event;
    public $id_user;

    const MASTER = 'master';
    const PLAYER = 'player';
    const NOTIFY = 'notify';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event, $id_user)
    {
        $this->event = $event;
        $this->id_user = $id_user;
    }
}
