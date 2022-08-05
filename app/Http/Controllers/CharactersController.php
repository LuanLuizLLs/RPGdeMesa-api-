<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Characters;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
  /**
   * Controller Characters
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

    $model = new Characters();
    $model->id_user = $id;
    $model->id_campaing = $request->id_campaing;
    $model->name = $request->name;
    $model->description = $request->description;
    $model->race = $request->race;;
    $model->caste = $request->caste;
    $model->tendency = $request->tendency;
    $model->life = $request->life;
    $model->coins = $request->coins;
    $model->actions = $request->actions;
    $model->strength = $request->strength;
    $model->dexterity = $request->dexterity;
    $model->constitution = $request->constitution;
    $model->intelligence = $request->intelligence;
    $model->wisdom = $request->wisdom;
    $model->charisma = $request->charisma;
    $model->save();

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem criado com sucesso',
    ], 200);
  }

  public function read(Request $request, $id = null)
  {
    $model = Characters::select()->where(function ($query) use ($request) {
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
      if (isset($request->id_campaing))
        $query = $query->where('id_campaing', $request->id_campaing);
    })->get();

    if ($id) $model = Characters::where('id', $id)->get();

    return response()->json([
      'response' => $model,
    ], 200);
  }

  public function update(Request $request, $id)
  {
    $model = Characters::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Personagem não encontrado',
      ], 400);
    }
    
    Characters::where('id', $id)->update([
      'id_user' => $request->id_user,
      'id_campaing' => $request->id_campaing,
      'name' => $request->name,
      'description' => $request->description,
      'race' => $request->race,
      'caste' => $request->caste,
      'tendency' => $request->tendency,
      'life' => $request->life,
      'coins' => $request->coins,
      'actions' => $request->actions,
      'strength' => $request->strength,
      'dexterity' => $request->dexterity,
      'constitution' => $request->constitution,
      'intelligence' => $request->intelligence,
      'wisdom' => $request->wisdom,
      'charisma' => $request->charisma,
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem atualizado com sucesso',
    ], 200);
  }

  public function delete($id)
  {
    $model = Characters::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    Characters::where('id', $id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário deletado com sucesso',
    ], 200);
  }
}
