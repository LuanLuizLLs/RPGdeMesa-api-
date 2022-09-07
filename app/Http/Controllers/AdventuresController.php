<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\Adventures;
use Illuminate\Http\Request;

class AdventuresController extends Controller
{
  /**
   * Controller Adventures
   */

  function create(Request $request)
  {
    $campaign = Campaigns::where('id', $request->id_campaign)->first();

    if (empty($campaign)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Campanha não encontrada',
        ],
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

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Aventura criada',
      ],
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Adventures::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->id_campaign))
        $query = $query->where('id_campaign', $request->id_campaign);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Aventura não encontrada',
        ],
      ], 400);
    }

    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Aventura encontrada',
      ],
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Adventures::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Aventura não encontrada',
        ],
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Adventures::where('id', $request->id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Aventura atualizada',
      ],
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Adventures::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Aventura não encontrada',
        ],
      ], 200);
    }

    Adventures::where('id', $request->id)->delete();
    Campaigns::where('id_adventure', $request->id)->update([
      'id_adventure' => null
    ]);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Aventura deletada',
      ],
    ], 200);
  }
}
