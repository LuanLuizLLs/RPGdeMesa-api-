<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\Interactions;
use Illuminate\Http\Request;

class InteractionsController extends Controller
{
  /**
   * Controller Interactions
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

    $model = new Interactions();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

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
        if (isset($request->id_campaign))
          $query = $query->where('id_campaign', $request->id_campaign);
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

    Interactions::where('id', $request->id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Interação deletada',
    ], 200);
  }
}
