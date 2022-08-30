<?php

namespace App\Http\Controllers;

use App\Models\Features;
use App\Models\Characters;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
  /**
   * Controller Features
   */

  function create(Request $request)
  {
    $character = Characters::where('id', $request->id_character)->first();
    $attributes = [
      'strength' => $character->strength + $request->strength,
      'dexterity' => $character->dexterity + $request->dexterity,
      'constitution' => $character->constitution + $request->constitution,
      'intelligence' => $character->intelligence + $request->intelligence,
      'wisdom' => $character->wisdom + $request->wisdom,
      'charisma' => $character->charisma + $request->charisma,
    ];

    if (empty($character)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
        ],
      ], 202);
    }

    if ($character->actions < 1 && $request->player) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Personagem não possui ações',
        ],
      ], 202);
    } elseif ($request->player) {
      Characters::where('id', $request->id_character)->update([
        'actions' => $character->actions - 1,
      ]);

      foreach ($attributes as $attribute) {
        if ($attribute > env('MAX_LEVEL_ATTRIBUTE')) {
          return response()->json([
            'message' => [
              'type' => 'warning',
              'message' => 'Atributo atingiu o nível máximo',
            ],
          ], 202);
        }
      };
    }

    $model = new Features();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    Characters::where('id', $request->id_character)->update($attributes);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Característica criada com sucesso',
      ],
    ], 200);
  }

  public function read(Request $request, $id = null)
  {
    $model = Features::select()->where(function ($query) use ($request) {
      if (isset($request->id_character))
        $query = $query->where('id_character', $request->id_character);
    })->get();

    if ($id) $model = Features::where('id', $id)->get();

    if (empty($model->all())) {
      return response()->json([
        'response' => $model,
        'message' =>  [
          'type' => 'warning',
          'message' => 'Característica não encontrada',
        ]
      ], 202);
    }

    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Característica encontrada com sucesso',
      ],
    ], 200);
  }

  public function delete($id)
  {
    $model = Features::where('id', $id)->first();
    $character = Characters::where('id', $model->id_character)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Característica não encontrada',
        ],
      ], 202);
    }

    Features::where('id', $id)->delete();

    Characters::where('id', $model->id_character)->update([
      'strength' => $character->strength - $model->strength,
      'dexterity' => $character->dexterity - $model->dexterity,
      'constitution' => $character->constitution - $model->constitution,
      'intelligence' => $character->intelligence - $model->intelligence,
      'wisdom' => $character->wisdom - $model->wisdom,
      'charisma' => $character->charisma - $model->charisma,
    ]);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Característica deletada',
      ],
    ], 200);
  }
}
