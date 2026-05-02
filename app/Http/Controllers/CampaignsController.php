<?php

namespace App\Http\Controllers;

use App\Events\PusherEvent;
use App\Models\Campaigns;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
  function create(Request $request)
  {
    $model = new Campaigns();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $data['id_user'] = auth()->user()->id;
    $model->create($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Campaigns::select()
      ->where('id_user', auth()->user()->id)
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Campanha não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Campaigns::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->update($data);

    Event(new PusherEvent(PusherEvent::MASTER, $request->id));

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Campaigns::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    $model->delete();

    Event(new PusherEvent(PusherEvent::MASTER, $request->id));

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha deletada',
    ], 200);
  }
}
