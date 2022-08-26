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
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 202);
    }

    $model = new Campaigns();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Campanha criada',
      ],
    ], 200);
  }

  public function read(Request $request, $id = null)
  {
    $model = Campaigns::select()->where(function ($query) use ($request) {
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
    })->get();
    
    if ($id) $model = Campaigns::where('id', $id)->get();

    if (empty($model->all())) {
      return response()->json([
        'response' => $model,
        'message' => [
          'type' => 'warning',
          'message' => 'Campanha não encontrada',
        ],
      ], 202);
    }
    
    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Campanha encontrada',
      ],
    ], 200);
  }

  public function update(Request $request, $id)
  {
    $model = Campaigns::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Campanha não encontrada',
        ],
      ], 200);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Campaigns::where('id', $id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Campanha atualizada',
      ],
    ], 200);
  }

  public function delete($id)
  {
    $model = Campaigns::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Campanha não encontrada',
        ],
      ], 200);
    }

    Campaigns::where('id', $id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Campanha deletada',
      ],
    ], 200);
  }
}
