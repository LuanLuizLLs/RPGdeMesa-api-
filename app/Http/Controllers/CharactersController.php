<?php

namespace App\Http\Controllers;

use App\Models\Characters;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
  function create(Request $request)
  {
    $model = new Characters();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $data[Characters::ID_USER] = auth()->user()->id;
    $data[Characters::LIFE] = Characters::INITIAL_LIFE;
    $data[Characters::COINS] = Characters::INITIAL_COINS;
    $data[Characters::ACTIONS] = Characters::INITIAL_ACTIONS;
    $data[Characters::STRENGTH] = Characters::INITIAL_STRENGTH;
    $data[Characters::DEXTERITY] = Characters::INITIAL_DEXTERITY;
    $data[Characters::CONSTITUTION] = Characters::INITIAL_CONSTITUTION;
    $data[Characters::INTELLIGENCE] = Characters::INITIAL_INTELLIGENCE;
    $data[Characters::WISDOW] = Characters::INITIAL_WISDOW;
    $data[Characters::CHARISMA] = Characters::INITIAL_CHARISMA;
    $model->create($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Characters::where(Characters::ID_USER, auth()->user()->id)
      ->when(isset($request->id), function ($query) use ($request) {
        return $query->where(Characters::ID, $request->id);
      })
      ->when(isset($request->id_campaign), function ($query) use ($request) {
        return $query->where(Characters::ID_CAMPAIGN, $request->id_campaign);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Personagem não encontrado',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem encontrado',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Characters::where(Characters::ID, $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem atualizado',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Characters::where(Characters::ID, $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    $model->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem deletado',
    ], 200);
  }
}
