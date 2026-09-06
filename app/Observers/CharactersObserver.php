<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Characters;
use App\Services\LoggerService;

class CharactersObserver
{
  use LoggerService;

  private function event(Characters $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::MASTER, $model->id));
    } catch (\Exception $e) {
      $this->error('Erro no observer de personagens', $e);
    }
  }

  public function updated(Characters $model)
  {
    $this->event($model);
  }

  public function deleted(Characters $model)
  {
    $this->event($model);
  }
}
