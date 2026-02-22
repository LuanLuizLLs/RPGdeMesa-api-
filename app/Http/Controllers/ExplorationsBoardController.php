<?php

namespace App\Http\Controllers;

use App\Models\Explorations;
use App\Models\ExplorationsBoard;
use Illuminate\Http\Request;

class ExplorationsBoardController extends Controller
{
  function create(Request $request)
  {
    $exploration = Explorations::where('id', $request->id_exploration)->first();

    if (empty($exploration)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Exploração não encontrada',
      ], 400);
    }

    ExplorationsBoard::where('active', true)->update([
      'active' => false
    ]);

    $exploration_board = ExplorationsBoard::where('id_exploration', $exploration->id)->first();

    if (empty($exploration_board)) {
      $board = array_pad([], $request->horizontal, null);
      $board = array_pad([], $request->vertical, $board);

      $model = new ExplorationsBoard();
      $model->create([
        'id_exploration' => $exploration->id,
        'active' => true,
        'board' => $board,
      ]);

      return response()->json([
        'status' => 'success',
        'message' => 'Exploração iniciada',
      ], 200);
    }

    ExplorationsBoard::where('id_exploration', $request->id_exploration)->update([
      'active' => true,
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Exploração iniciada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = ExplorationsBoard::select(['explorations.*', 'explorations_board.*'])
      ->join('explorations', 'explorations_board.id_exploration', 'explorations.id')
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('explorations.id', $request->id);
        if (isset($request->id_scenery))
          $query = $query->where('explorations.id_scenery', $request->id_scenery);
        if (isset($request->active))
          $query = $query->where('explorations_board.active', $request->active);
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
    $model = ExplorationsBoard::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Exloração não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    ExplorationsBoard::where('id', $request->id)->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Exloração atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = ExplorationsBoard::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Exloração não encontrada',
      ], 400);
    }

    ExplorationsBoard::where('id', $request->id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Exloração removida',
    ], 200);
  }
}
