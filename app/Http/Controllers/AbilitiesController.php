<?php

namespace App\Http\Controllers;

use App\Models\Abilities;
use App\Models\Characters;
use Illuminate\Http\Request;

class AbilitiesController extends Controller
{
  /**
   * Controller Abilities
   */

  function create(Request $request)
  {
    $character = Characters::where('id', $request->id_character)->first();

    if (empty($character)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
        ],
      ], 400);
    }

    $model = new Abilities();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade criada',
      ],
    ], 200);
  }

  public function read(Request $request, $id = null)
  {
    $model = Abilities::select()->where(function ($query) use ($request) {
      if (isset($request->id_character))
        $query = $query->where('id_character', $request->id_character);
    })->get();

    if ($id) $model = Abilities::where('id', $id)->get();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Habilidade não encontrada',
      ], 400);
    }
    
    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade encontrada',
      ],
    ], 200);
  }

  public function update(Request $request, $id)
  {
    $model = Abilities::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Habilidade não encontrada',
        ],
      ], 400);
    }
    
    $data = array_intersect_key($request->all(), $model->getCasts());
    Abilities::where('id', $id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade atualizada',
      ],
    ], 200);
  }
  
  public function delete($id)
  {
    $model = Abilities::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Habilidade não encontrada',
        ],
      ], 400);
    }

    Abilities::where('id', $id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade deletada',
      ],
    ], 200);
  }
}
