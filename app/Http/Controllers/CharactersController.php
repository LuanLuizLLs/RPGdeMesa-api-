<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Characters;
use App\Models\Features;
use App\Models\Abilities;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
  /**
   * Controller Characters
   */

  function create(Request $request)
  {
    $user = Users::where('id', $request->id_user)->first();
    
    if (empty($user)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Usuário não encontrado',
        ],
      ], 400);
    }

    $model = new Characters();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $data['life'] = $model->getLifeCapacity($data);
    $data['actions'] = $model->getPhysicalCapacity($data);
    $data['coins'] = $model->getMentalCapacity($data) * $request->riches;
    $model->create($data);
    
    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Personagem criado',
      ],
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Characters::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
      if (isset($request->id_campaign))
        $query = $query->where('id_campaign', $request->id_campaign);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'response' => $model,
        'message' => [
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
        ]
      ], 202);
    }

    if ($request->user || $request->campaign) {
      $character = $model->first();
      
      if ($character->id_campaign != $request->campaign && $character->id_user != $request->user) {
        return response()->json([
          'message' => [
            'type' => 'error',
            'message' => 'Usuário não permitido',
          ]
        ], 400);
      }
    }

    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Personagem encontrado',
      ],
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Characters::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Personagem não encontrado',
        ],
      ], 400);
    }

    if ($request->life)
      if ($request->life > $model->getLifeCapacity()) {
        return response()->json([
          'message' => [
            'type' => 'warning',
            'message' => 'Vida no limite máximo',
          ],
        ], 202);
      }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Characters::where('id', $request->id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Personagem atualizado',
      ],
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Characters::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Personagem não encontrado',
        ],
      ], 400);
    }

    Characters::where('id', $request->id)->delete();
    Features::where('id_character', $request->id)->delete();
    Abilities::where('id_character', $request->id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Personagem deletado',
      ],
    ], 200);
  }
}
