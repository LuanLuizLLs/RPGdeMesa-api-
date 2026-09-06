<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Scenarios;
use App\Services\LoggerService;

class ScenariosObserver
{
  use LoggerService;

  private function event(Scenarios $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::MASTER, $model->id));
    } catch (\Exception $e) {
      $this->error('Erro no observer de cenários', $e);
    }
  }

  public function created(Scenarios $model)
  {
    $this->event($model);
  }

  public function updated(Scenarios $model)
  {
    $this->event($model);
  }

  public function deleted(Scenarios $model)
  {
    $this->event($model);
  }
}
