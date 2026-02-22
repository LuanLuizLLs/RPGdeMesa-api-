<?php

namespace App\Http\Controllers;

use App\Models\Abilities;
use App\Models\Characters;
use Illuminate\Http\Request;

class AbilitiesController extends Controller
{
  function create(Request $request)
  {
    $character = Characters::where('id', $request->id_character)->first();
    $quantity_abilities = Abilities::quantityAbilities($request->id_character);

    if (empty($character)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    if ($quantity_abilities >= $character->capacity['mental']) {
      return response()->json([
        'status' => 'error',
        'message' => 'Capacidade de habilidades atingida',
      ], 400);
    }

    if ($request->level > Abilities::MAX_LEVEL_ABILITY) {
      return response()->json([
        'status' => 'error',
        'message' => 'Habilidade atingiu o nível máximo',
      ], 400);
    }

    $model = new Abilities();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Habilidade criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Abilities::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_character))
          $query = $query->where('id_character', $request->id_character);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Habilidade não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Habilidade encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Abilities::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Habilidade não encontrada',
      ], 400);
    }

    if ($request->level > Abilities::MAX_LEVEL_ABILITY) {
      return response()->json([
        'status' => 'error',
        'message' => 'Habilidade atingiu o nível máximo',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Abilities::where('id', $request->id)->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Habilidade atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Abilities::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Habilidade não encontrada',
      ], 400);
    }

    Abilities::where('id', $request->id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Habilidade deletada',
    ], 200);
  }
}
