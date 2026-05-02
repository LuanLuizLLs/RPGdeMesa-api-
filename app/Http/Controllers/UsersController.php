<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  function create(Request $request)
  {
    $model = Users::where('username', $request->username)->first();

    if ($model) {
      return response()->json([
        'status' => 'error',
        'message' => 'Usuário já existe',
      ], 400);
    }

    $model = new Users();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Users::select()
      ->where(
        function ($query) use ($request) {
          if (isset($request->id))
            $query = $query->where('id', $request->id);
          if (isset($request->username))
            $query = $query->where('username', $request->username);
        }
      )->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Usuário não encontrado',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário encontrado',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Users::select()
      ->where(function ($query) use ($request) {
        if (isset($request->username))
          $query = $query->where('username', $request->username);
      })
      ->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Users::where('id', $model->id)->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário atualizado',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Users::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Usuário não encontrada',
      ], 400);
    }

    Users::where('id', $request->id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário deletado',
    ], 200);
  }
}
