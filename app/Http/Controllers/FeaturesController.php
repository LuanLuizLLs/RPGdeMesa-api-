<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Features;
use App\Models\Characters;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
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
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    $model = new Features();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    Characters::where('id', $request->id_character)->update($attributes);
    
    event(new SseEvent('player', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Característica criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Features::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_character))
          $query = $query->where('id_character', $request->id_character);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'error',
        'message' => 'Característica não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Característica encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Features::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Característica não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Features::where('id', $request->id)->update($data);

    event(new SseEvent('player', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Característica atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Features::where('id', $request->id)->first();
    $character = Characters::where('id', $model->id_character)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Característica não encontrada',
      ], 400);
    }

    Features::where('id', $request->id)->delete();

    Characters::where('id', $model->id_character)->update([
      'strength' => $character->strength - $model->strength,
      'dexterity' => $character->dexterity - $model->dexterity,
      'constitution' => $character->constitution - $model->constitution,
      'intelligence' => $character->intelligence - $model->intelligence,
      'wisdom' => $character->wisdom - $model->wisdom,
      'charisma' => $character->charisma - $model->charisma,
    ]);

    event(new SseEvent('player', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Característica deletada',
    ], 200);
  }
}
