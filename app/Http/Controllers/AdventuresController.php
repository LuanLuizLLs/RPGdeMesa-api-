<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Campaigns;
use App\Models\Adventures;
use Illuminate\Http\Request;

class AdventuresController extends Controller
{
  function create(Request $request)
  {
    $campaign = Campaigns::where('id', $request->id_campaign)->first();

    if (empty($campaign)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    $model = new Adventures();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    $adventure_created = Adventures::where('id_campaign', $request->id_campaign)
      ->orderBy('created_at', 'desc')
      ->first();

    Campaigns::where('id', $request->id_campaign)->update([
      'id_adventure' => $adventure_created->id
    ]);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Aventura criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Adventures::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_campaign))
          $query = $query->where('id_campaign', $request->id_campaign);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Aventura não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Aventura encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Adventures::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Aventura não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Adventures::where('id', $request->id)->update($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Aventura atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Adventures::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Aventura não encontrada',
      ], 400);
    }

    Adventures::where('id', $request->id)->delete();
    Campaigns::where('id_adventure', $request->id)->update([
      'id_adventure' => null
    ]);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Aventura deletada',
    ], 200);
  }
}
