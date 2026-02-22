<?php

namespace App\Http\Controllers;

use App\Models\Sse;
use App\Events\SseEvent;

class SseController extends Controller
{
  public function index($id)
  {
    $sse = Sse::where('id_user', $id)->get();
    return response(view('services/sse', ['sse' => $sse]), 200, [
      'Content-Type' => 'text/event-stream',
      'Cache-Control' => 'no-cache',
      'Connection' => 'keep-alive',
    ]);
  }

  public function event(SseEvent $sse)
  {
    Sse::updateOrCreate([
      ['event', $sse->event],
      ['id_user', $sse->id_user]
    ], [
      'event' => $sse->event,
      'id_user' => $sse->id_user,
      'triggered_at' => date('Y-m-d H:i:s'),
    ]);
  }
}
