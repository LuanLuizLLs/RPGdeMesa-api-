<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Campaigns;
use App\Services\LoggerService;

class CampaignsObserver
{
  use LoggerService;

  private function event(Campaigns $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::MASTER, $model->id));
    } catch (\Exception $e) {
      $this->error('Erro no observer de campanhas', $e);
    }
  }

  public function updated(Campaigns $model)
  {
    $this->event($model);
  }

  public function deleted(Campaigns $model)
  {
    $this->event($model);
  }
}
