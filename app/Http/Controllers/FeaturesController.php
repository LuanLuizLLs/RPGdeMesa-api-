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

    if (empty($character)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
        ],
      ], 400);
    }

    $model = new Features();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    Characters::where('id', $request->id_character)->update([
      'strength' => $character->strength + $request->strength,
      'dexterity' => $character->dexterity + $request->dexterity,
      'constitution' => $character->constitution + $request->constitution,
      'intelligence' => $character->intelligence + $request->intelligence,
      'wisdom' => $character->wisdom + $request->wisdom,
      'charisma' => $character->charisma + $request->charisma,
    ]);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Característica criada',
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

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Característica não encontrada',
      ], 400);
    }
    
    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Característica encontrada',
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
      ], 400);
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
