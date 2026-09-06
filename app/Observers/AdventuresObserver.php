<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Adventures;
use App\Services\LoggerService;

class AdventuresObserver
{
  use LoggerService;

  private function event(Adventures $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::MASTER, $model->id_campaign));
    } catch (\Exception $e) {
      $this->error('Erro no observer de aventuras', $e);
    }
  }

  public function created(Adventures $model)
  {
    $this->event($model);
  }

  public function updated(Adventures $model)
  {
    $this->event($model);
  }

  public function deleted(Adventures $model)
  {
    $this->event($model);
  }
}
