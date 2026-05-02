<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Interactions;

class InteractionsObserver
{
  public function updated(Interactions $model)
  {
    Event(new PusherEvent(PusherEvent::INTERACTION, $model->id_adventure));
  }
}
