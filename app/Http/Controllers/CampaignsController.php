<?php

namespace App\Http\Controllers;

use App\Events\SseEvent;
use App\Models\Users;
use App\Models\Campaigns;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
  function create(Request $request)
  {
    $user = Users::where('id', $request->id_user)->first();

    if (empty($user)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    $model = new Campaigns();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha criada',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Campaigns::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_user))
          $query = $query->where('id_user', $request->id_user);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Campanha não encontrada',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha encontrada',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Campaigns::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Campaigns::where('id', $request->id)->update($data);

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha atualizada',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Campaigns::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Campanha não encontrada',
      ], 400);
    }

    Campaigns::where('id', $request->id)->delete();

    event(new SseEvent('master', date('Y-m-d H:i:s')));

    return response()->json([
      'status' => 'success',
      'message' => 'Campanha deletada',
    ], 200);
  }
}
