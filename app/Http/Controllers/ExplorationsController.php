<?php

namespace App\Http\Controllers;

use App\Models\Scenarios;
use App\Models\Explorations;
use App\Models\ExplorationsBoard;
use Illuminate\Http\Request;

class ExplorationsController extends Controller
{
  function create(Request $request)
  {
    $scenary = Scenarios::where('id', $request->id_scenery)->first();

    if (empty($scenary)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Cenário não encontrado',
      ], 400);
    }

    $model = new Explorations();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

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
        if (isset($request->id_scenery))
          $query = $query->where('id_scenery', $request->id_scenery);
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
    $model->update($data);

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

    $model->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Exploração deletada',
    ], 200);
  }
}
