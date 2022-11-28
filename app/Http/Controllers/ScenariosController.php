<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\Scenarios;
use Illuminate\Http\Request;

class ScenariosController extends Controller
{
  /**
   * Controller Scenarios
   */

  function create(Request $request)
  {
    $campaign = Campaigns::where('id', $request->id_campaign)->first();

    if (empty($campaign)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    $model = new Scenarios();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    $scenery_created = Scenarios::where('id_campaign', $request->id_campaign)
      ->orderBy('created_at', 'desc')
      ->first();

    Campaigns::where('id', $request->id_campaign)->update([
      'id_scenery' => $scenery_created->id
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Cenário criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Scenarios::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->id_campaign))
        $query = $query->where('id_campaign', $request->id_campaign);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Cenário não encontrado',
        'response' => $model,
      ], 400);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Cenário encontrado',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Scenarios::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Cenário não encontrado',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Scenarios::where('id', $request->id)->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Cenário atualizado',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Scenarios::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Cenário não encontrado',
      ], 400);
    }

    Scenarios::where('id', $request->id)->delete();
    Campaigns::where('id_adventure', $request->id)->update([
      'id_adventure' => null
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Cenário deletado',
    ], 200);
  }
}
