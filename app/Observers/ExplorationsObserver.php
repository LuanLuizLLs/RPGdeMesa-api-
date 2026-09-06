<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Explorations;
use App\Services\LoggerService;

class ExplorationsObserver
{
  use LoggerService;

  public function updated(Explorations $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::EXPLORATION, $model->id_scenery));
    } catch (\Exception $e) {
      $this->error('Erro no observer de explorações', $e);
    }
  }
}
