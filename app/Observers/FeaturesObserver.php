<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Features;
use App\Services\LoggerService;

class FeaturesObserver
{
  use LoggerService;

  private function event(Features $model)
  {
    try {
      Event(new PusherEvent(PusherEvent::PLAYER, $model->id_character));

      if ($id_campaign = $model->getIdCampaign()) {
        Event(new PusherEvent(PusherEvent::MASTER, $id_campaign));
      }
    } catch (\Exception $e) {
      $this->error('Erro no observer de características', $e);
    }
  }

  public function created(Features $model)
  {
    $this->event($model);
  }

  public function updated(Features $model)
  {
    $this->event($model);
  }

  public function deleted(Features $model)
  {
    $this->event($model);
  }
}
