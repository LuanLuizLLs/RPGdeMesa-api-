<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Explorations;

class ExplorationsObserver
{
  public function updated(Explorations $model)
  {
    Event(new PusherEvent(PusherEvent::EXPLORATION, $model->id_scenery));
  }
}
