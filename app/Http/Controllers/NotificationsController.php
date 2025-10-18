<?php

namespace App\Http\Controllers;

use App\Enums\NotificationTypesEnum;
use App\Enums\SseKeysEnum;
use App\Events\SseEvent;
use App\Models\Characters;
use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
  function create(Request $request)
  {

    switch ($request->type) {
      case NotificationTypesEnum::INVITE_CAMPAIGN:
        $character = Characters::where('id', $request->id)->first();

        Notifications::create([
          'type' => $request->type,
          'id_user' => $character->id_user,
          'domain' => 'characters',
          'action' => 'update',
          'data' => [
            'id' => $character->id,
            'id_campaign' => $request->id_campaign,
            'name_campaign' => $request->name_campaign,
          ],
        ]);
        break;

      default:
        return response()->json([
          'status' => 'error',
          'message' => 'Notificação inválida',
        ], 400);
    }

    event(new SseEvent(SseKeysEnum::NOTIFICATION, date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Notificação criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Notifications::select()
      ->where('id_user', auth()->user()->id)
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Notificação não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Notificação encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Notifications::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Notificação não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Notifications::where('id', $request->id)->update($data);

    event(new SseEvent(SseKeysEnum::NOTIFICATION, date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Notificação atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Notifications::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Notificação não encontrada',
      ], 400);
    }

    Notifications::where('id', $request->id)->delete();

    event(new SseEvent(SseKeysEnum::NOTIFICATION, date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Notificação deletada',
    ], 200);
  }
}
