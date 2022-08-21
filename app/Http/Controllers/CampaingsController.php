<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Campaings;
use Illuminate\Http\Request;

class CampaingsController extends Controller
{
  /**
   * Controller Campaings
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

    $model = new Campaings();
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
    $model = Campaings::select()->where(function ($query) use ($request) {
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
    })->get();
    
    if ($id) $model = Campaings::where('id', $id)->get();

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
    $model = Campaings::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Campanha não encontrada',
        ],
      ], 200);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Campaings::where('id', $id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Campanha atualizada',
      ],
    ], 200);
  }

  public function delete($id)
  {
    $model = Campaings::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Campanha não encontrada',
        ],
      ], 200);
    }

    Campaings::where('id', $id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Campanha deletada',
      ],
    ], 200);
  }
}
