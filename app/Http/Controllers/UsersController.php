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
          'message' => [
            'type' => 'warning',
            'message' => 'Usuário já existe',
          ],
        ], 400);
      }

    $model = new Users();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Usuário criado com sucesso',
      ],
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Users::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->name))
        $query = $query->where('name', $request->name);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Usuário não encontrado',
        ],
      ], 400);
    }

    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Usuário encontrado com sucesso',
      ],
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
        'message' => [
          'type' => 'error',
          'message' => 'Usuário não encontrado',
        ],
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Users::where('id', $model->id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Usuário atualizado com sucesso',
      ]
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Users::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrada',
        ],
      ], 400);
    }

    Users::where('id', $request->id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Usuário deletada com sucesso',
      ],
    ], 200);
  }
}
