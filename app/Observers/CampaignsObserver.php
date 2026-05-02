<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\Campaigns;

class CampaignsObserver
{
  public function updated(Campaigns $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id));
  }

  public function deleted(Campaigns $model)
  {
    Event(new PusherEvent(PusherEvent::MASTER, $model->id));
  }
}
