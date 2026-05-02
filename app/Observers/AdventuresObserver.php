<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Adventures;

class AdventuresObserver
{
  public function created(Adventures $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
  }

  public function updated(Adventures $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
  }

  public function deleted(Adventures $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
  }
}
