<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\ExplorationsBoard;

class ExplorationsBoardObserver
{
  public function created(ExplorationsBoard $model)
  {
    Event(new PusherEvent(PusherEvent::EXPLORATION, $model->getIdScenery()));
  }

  public function updated(ExplorationsBoard $model)
  {
    Event(new PusherEvent(PusherEvent::EXPLORATION, $model->getIdScenery()));
  }

  public function deleted(ExplorationsBoard $model)
  {
    Event(new PusherEvent(PusherEvent::EXPLORATION, $model->getIdScenery()));
  }
}
