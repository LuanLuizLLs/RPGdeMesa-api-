<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  /**
   * Controller Users
   */

  function create(Request $request)
  {
    $model = Users::where('name', $request->name)->first();

    if ($model)
      if ($model->name === $request->name) {
        return response()->json([
          'message' => 'Usuário já existe',
        ], 400);
      }

    $model = new Users();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'message' => 'Usuário criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Users::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->name))
        $query = $query->where('name', $request->name);
      if (isset($request->password))
        $query = $query->where('password', $request->password);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    return response()->json([
      'response' => $model,
      'message' => 'Usuário encontrado',
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Users::select()->where(function ($query) use ($request) {
      if (isset($request->name))
        $query = $query->where('name', $request->name);
    })->first();

    if (empty($model)) {
      return response()->json([
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Users::where('id', $model->id)->update($data);

    return response()->json([
      'message' => 'Usuário atualizado',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Users::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => 'Usuário não encontrada',
      ], 400);
    }

    Users::where('id', $request->id)->delete();

    return response()->json([
      'message' => 'Usuário deletado',
    ], 200);
  }
}
