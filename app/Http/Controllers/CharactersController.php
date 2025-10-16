<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Characters;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
  function create(Request $request)
  {
    $model = new Characters();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $data['life'] = $model->lifeCapacity($data);
    $data['coins'] = $model->mentalCapacity($data);
    $data['actions'] = $model->physicalCapacity($data);
    $data['id_user'] = auth()->user()->id;
    $model->create($data);

    event(new SseEvent('player', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Characters::select()
      ->where('id_user', auth()->user()->id)
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_campaign))
          $query = $query->where('id_campaign', $request->id_campaign);
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
    $model = Characters::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Characters::where('id', $request->id)->update($data);

    event(new SseEvent('player', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem atualizado',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Characters::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    Characters::where('id', $request->id)->delete();

    event(new SseEvent('player', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem deletado',
    ], 200);
  }
}
