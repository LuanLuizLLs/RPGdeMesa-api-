<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Explorations;
use App\Models\ExplorationsBoard;
use Illuminate\Http\Request;

class ExplorationsBoardController extends Controller
{
  function create(Request $request)
  {
    $interaction = Explorations::where('id', $request->id_exploration)->first();

    if (empty($interaction)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Exploração não encontrada',
      ], 400);
    }

    ExplorationsBoard::where('active', true)->update([
      'active' => false
    ]);

    $exploration_board = ExplorationsBoard::where('id_exploration', $request->id_exploration)->first();

    if (empty($exploration_board)) {
      $board = array_pad([], $request->horizontal, null);
      $board = array_pad([], $request->vertical, $board);

      $model = new ExplorationsBoard();
      $model->create([
        'id_exploration' => $request->id_exploration,
        'active' => true,
        'board' => $board,
      ]);

      event(new SseEvent('master', date('Y-m-d H:i:s')));

      return response()->json([
        'status' => 'success',
        'message' => 'Exploração iniciada',
      ], 200);
    }

    ExplorationsBoard::where('id_exploration', $request->id_exploration)->update([
      'active' => true,
    ]);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

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
        if (isset($request->id_campaign))
          $query = $query->where('explorations.id_campaign', $request->id_campaign);
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

    event(new SseEvent('master', date('Y-m-d H:i:s')));

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

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Exloração removida',
    ], 200);
  }
}
