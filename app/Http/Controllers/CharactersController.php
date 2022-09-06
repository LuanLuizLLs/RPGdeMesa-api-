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
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 202);
    }

    $model = new Characters();
    $data = array_intersect_key($request->all(), $model->getCasts());
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
      if (isset($request->id_user))
        $query = $query->where('id_user', $request->id_user);
      if (isset($request->id_campaign))
        $query = $query->where('id_campaign', $request->id_campaign);
    })->get();

    if ($request->id) $model = Characters::where('id', $request->id)->get();

    if (empty($model->all())) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
        ],
      ], 200);
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
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
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
          'type' => 'warning',
          'message' => 'Personagem não encontrado',
        ],
      ], 202);
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
