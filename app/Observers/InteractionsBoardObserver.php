<?php

namespace App\Observers;

use App\Events\PusherEvent;
use App\Models\InteractionsBoard;

class InteractionsBoardObserver
{
  public function created(InteractionsBoard $model)
  {
    Event(new PusherEvent(PusherEvent::INTERACTION, $model->getIdAdventure()));
  }

  public function updated(InteractionsBoard $model)
  {
    Event(new PusherEvent(PusherEvent::INTERACTION, $model->getIdAdventure()));
  }

  public function deleted(InteractionsBoard $model)
  {
    Event(new PusherEvent(PusherEvent::INTERACTION, $model->getIdAdventure()));
  }
}
