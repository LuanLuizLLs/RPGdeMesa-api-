<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Adventures;
use App\Models\Interactions;
use App\Models\InteractionsBoard;
use Illuminate\Http\Request;

class InteractionsController extends Controller
{
  function create(Request $request)
  {
    $adventure = Adventures::where('id', $request->id_adventure)->first();

    if (empty($adventure)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Aventura não encontrada',
      ], 400);
    }

    $model = new Interactions();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Interação criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Interactions::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_adventure))
          $query = $query->where('id_adventure', $request->id_adventure);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Interação não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Interação encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Interactions::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Interação não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Interactions::where('id', $request->id)->update($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Interação atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Interactions::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Interação não encontrada',
      ], 400);
    }

    $interactions_board = InteractionsBoard::where('id_interaction', $request->id)->first();

    if ($interactions_board) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Interação em uso',
      ], 400);
    }

    Interactions::where('id', $request->id)->delete();

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Interação deletada',
    ], 200);
  }
}
