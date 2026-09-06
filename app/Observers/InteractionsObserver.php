<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Interactions;
use App\Services\LoggerService;

class InteractionsObserver
{
  use LoggerService;

  public function updated(Interactions $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::INTERACTION, $model->id_adventure));
    } catch (\Exception $e) {
      $this->error('Erro no observer de interações', $e);
    }
  }
}
