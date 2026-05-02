<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PusherEvent extends Event implements ShouldBroadcast
{
  public $id = '';
  public $key = '';
  public $channel = '';

  const MASTER = 'master';
  const PLAYER = 'player';
  const INTERACTION = 'interaction';
  const EXPLORATION = 'exploration';

  public function __construct(string $channel, int $id)
  {
    $this->id = $id;
    $this->channel = $channel;
  }

  public function broadcastOn()
  {
    return new Channel($this->channel . '.' . $this->id);
  }
}
