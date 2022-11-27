<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Campaigns;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
  /**
   * Controller Campaigns
   */

  function create(Request $request)
  {
    $user = Users::where('id', $request->id_user)->first();

    if (empty($user)) {
      return response()->json([
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    $model = new Campaigns();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'message' => 'Campanha criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Campaigns::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
    })->get();
    
    if (empty($model->all())) {
      return response()->json([
        'message' => 'Campanha não encontrada',
      ], 400);
    }
    
    return response()->json([
      'response' => $model,
      'message' => 'Campanha encontrada',
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Campaigns::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Campaigns::where('id', $request->id)->update($data);

    return response()->json([
      'message' => 'Campanha atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Campaigns::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    Campaigns::where('id', $request->id)->delete();

    return response()->json([
      'message' => 'Campanha deletada',
    ], 200);
  }
}
