<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Features;

class FeaturesObserver
{
  public function created(Features $model)
  {
    Event(new PusherEvent(PusherEvent::PLAYER, $model->id));

    if ($id_campaign = $model->getIdCampaign()) {
      Event(new PusherEvent(PusherEvent::MASTER, $id_campaign));
    }
  }

  public function updated(Features $model)
  {
    Event(new PusherEvent(PusherEvent::PLAYER, $model->id));

    if ($id_campaign = $model->getIdCampaign()) {
      Event(new PusherEvent(PusherEvent::MASTER, $id_campaign));
    }
  }

  public function deleted(Features $model)
  {
    Event(new PusherEvent(PusherEvent::PLAYER, $model->id));

    if ($id_campaign = $model->getIdCampaign()) {
      Event(new PusherEvent(PusherEvent::MASTER, $id_campaign));
    }
  }
}
