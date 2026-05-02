<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Scenarios;

class ScenariosObserver
{
  public function created(Scenarios $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
  }

  public function updated(Scenarios $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
  }

  public function deleted(Scenarios $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
  }
}
