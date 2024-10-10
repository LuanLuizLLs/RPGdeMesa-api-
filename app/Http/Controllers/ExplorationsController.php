<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Campaigns;
use App\Models\Explorations;
use App\Models\ExplorationsBoard;
use Illuminate\Http\Request;

class ExplorationsController extends Controller
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

    $model = new Explorations();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Exploração criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Explorations::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_campaign))
          $query = $query->where('id_campaign', $request->id_campaign);
        if (isset($request->active))
          $query = $query->where('active', $request->active);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Exploração não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Exploração encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Explorations::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Exploração não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Explorations::where('id', $request->id)->update($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Exploração atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Explorations::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Exploração não encontrada',
      ], 400);
    }

    $explorations_board = ExplorationsBoard::where([
      'id_exploration' => $request->id,
      'active' => true,
    ])->first();

    if ($explorations_board) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Exploração em uso',
      ], 400);
    }

    Explorations::where('id', $request->id)->delete();

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Exploração deletada',
    ], 200);
  }
}
