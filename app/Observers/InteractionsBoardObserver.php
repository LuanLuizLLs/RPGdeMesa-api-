<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\InteractionsBoard;
use App\Services\LoggerService;

class InteractionsBoardObserver
{
  use LoggerService;

  private function event(InteractionsBoard $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::INTERACTION, $model->getIdAdventure()));
    } catch (\Exception $e) {
      $this->error('Erro no observer de tabuleiro de interações', $e);
    }
  }

  public function created(InteractionsBoard $model)
  {
    $this->event($model);
  }

  public function updated(InteractionsBoard $model)
  {
    $this->event($model);
  }

  public function deleted(InteractionsBoard $model)
  {
    $this->event($model);
  }
}
