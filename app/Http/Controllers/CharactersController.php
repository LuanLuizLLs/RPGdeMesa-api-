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
    $created = $model->create($data);

    event(new SseEvent(SseEvent::PLAYER, $created->id_user));

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Characters::select('characters.*')
      ->selectRaw('COALESCE(campaigns.id_user, characters.id_user) as auth_user')
      ->leftJoin('campaigns', 'characters.id_campaign', '=', 'campaigns.id')
      ->when(empty($request->only(['id', 'id_campaign'])), function ($query) {
        return $query->where('characters.id_user', auth()->user()->id);
      }, function ($query) {
        return $query->having('auth_user', auth()->user()->id);
      })
      ->when($request->id, function ($query, $id) {
        return $query->where('characters.id', $id);
      })
      ->when($request->id_campaign, function ($query, $id_campaign) {
        return $query->where('characters.id_campaign',  $id_campaign);
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
    $updated = tap($model)->update($data);

    event(new SseEvent(SseEvent::PLAYER, $updated->id_user));

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

    $deleted = tap($model)->delete();

    event(new SseEvent(SseEvent::PLAYER, $deleted->id_user));

    return response()->json([
      'status' => 'success',
      'message' => 'Personagem deletado',
    ], 200);
  }
}
