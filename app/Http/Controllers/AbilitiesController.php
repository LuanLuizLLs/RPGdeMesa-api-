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
          'type' => 'error',
          'message' => 'Personagem não encontrado',
        ],
      ], 400);
    }

    if ($request->player)
      if ($character->actions < 1) {
        return response()->json([
          'message' => [
            'type' => 'error',
            'message' => 'Personagem não possui ações',
          ],
        ], 400);
      } elseif ($request->player) {
        Characters::where('id', $request->id_character)->update([
          'actions' => $character->actions - 1,
        ]);
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

  public function read(Request $request)
  {
    $model = Abilities::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->id_character))
        $query = $query->where('id_character', $request->id_character);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'response' => $model,
        'message' => [
          'type' => 'warning',
          'message' => 'Habilidade não encontrada',
        ]
      ], 202);
    }
    
    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade encontrada',
      ],
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Abilities::where('id', $request->id)->first();
    $character = Characters::where('id', $model->id_character)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Habilidade não encontrada',
        ],
      ], 400);
    }

    if ($request->player)
      if ($character->actions < 1) {
        return response()->json([
          'message' => [
            'type' => 'error',
            'message' => 'Personagem não possui ações',
          ],
        ], 400);
      } elseif ($request->player) {
        if ($request->level > Abilities::MAX_LEVEL_ABILITY) {
          return response()->json([
            'message' => [
              'type' => 'error',
              'message' => 'Habilidade atingiu o nível máximo',
            ],
          ], 400);
        }

        Characters::where('id', $model->id_character)->update([
          'actions' => $character->actions - 1,
        ]);
      }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Abilities::where('id', $request->id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade atualizada',
      ],
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Abilities::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Habilidade não encontrada',
        ],
      ], 400);
    }

    Abilities::where('id', $request->id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Habilidade deletada',
      ],
    ], 200);
  }
}
