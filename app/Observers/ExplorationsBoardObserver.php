<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\ExplorationsBoard;
use App\Services\LoggerService;

class ExplorationsBoardObserver
{
  use LoggerService;

  private function event(ExplorationsBoard $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::EXPLORATION, $model->getIdScenery()));
    } catch (\Exception $e) {
      $this->error('Erro no observer de tabuleiro de explorações', $e);
    }
  }

  public function created(ExplorationsBoard $model)
  {
    $this->event($model);
  }

  public function updated(ExplorationsBoard $model)
  {
    $this->event($model);
  }

  public function deleted(ExplorationsBoard $model)
  {
    $this->event($model);
  }
}
