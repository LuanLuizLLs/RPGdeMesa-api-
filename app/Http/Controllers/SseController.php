<?php

namespace App\Http\Controllers;

use App\Models\Sse;
use App\Events\SseEvent;

class SseController extends Controller
{
  public function index()
  {
    $sse = Sse::select()->get();
    return response(view('services/sse', ['sse' => $sse]), 200, ['Content-Type' => 'text/event-stream']);
  }

  public function event(SseEvent $sse)
  {
    $model = Sse::where('event', $sse->event);
    $data = [
      'event' => $sse->event,
      'data' => $sse->data,
    ];

    if (empty($model->first())) {
      Sse::create($data);
    } else {
      $model->update($data);
    }
  }
}
