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

  function create(Request $request, $id)
  {
    $model = Users::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    $model = new Campaings();
    $model->id_user = $id;
    $model->name = $request->name;
    $model->description = $request->description;
    $model->save();

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha criada com sucesso',
    ], 200);
  }

  public function read(Request $request, $id = null)
  {
    $model = Campaings::select()->where(function ($query) use ($request) {
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
    })->get();

    if ($id) $model = Campaings::where('id', $id)->get();

    return response()->json([
      'response' => $model,
    ], 200);
  }

  public function update(Request $request, $id)
  {
    $model = Campaings::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Campanha não encontrada',
      ], 200);
    }

    Campaings::where('id', $id)->update([
      'id_user' => $request->id_user,
      'name' => $request->name,
      'description' => $request->description,
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha atualizada com sucesso',
    ], 200);
  }

  public function delete($id)
  {
    $model = Campaings::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Campanha não encontrada',
      ], 200);
    }

    Campaings::where('id', $id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha deletada com sucesso',
    ], 200);
  }
}
