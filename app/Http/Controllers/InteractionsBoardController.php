<?php

namespace App\Http\Controllers;

use App\Models\Interactions;
use App\Models\InteractionsBoard;
use Illuminate\Http\Request;

class InteractionsBoardController extends Controller
{
  function create(Request $request)
  {
    $interaction = Interactions::where('id', $request->id_interaction)->first();

    if (empty($interaction)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Interação não encontrada',
      ], 400);
    }

    $model = new InteractionsBoard();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Interação adicionada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = InteractionsBoard::select('*')
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_interaction))
          $query = $query->where('id_interaction', $request->id_interaction);
      })
      ->get()
      ->load(['shape']);

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
    $model = InteractionsBoard::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Interação não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    InteractionsBoard::where('id', $request->id)->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Interação atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = InteractionsBoard::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Interação não encontrada',
      ], 400);
    }

    InteractionsBoard::where('id', $request->id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Interação removida',
    ], 200);
  }
}
