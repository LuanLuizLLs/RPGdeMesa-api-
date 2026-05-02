<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Characters;

class CharactersObserver
{
  public function updated(Characters $model)
  {
    Event(new PusherEvent(PusherEvent::PLAYER, $model->id));
  }

  public function deleted(Characters $model)
  {
    Event(new PusherEvent(PusherEvent::PLAYER, $model->id));
  }
}
