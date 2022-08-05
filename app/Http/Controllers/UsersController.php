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
    $model = Users::where('user', $request->user)->first();

    if ($model)
      if ($model->user === $request->user) {
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
        'message' => 'Usuário criado',
      ],
    ], 200);
  }

  public function read(Request $request, $id = null)
  {
    $model = Users::select()->where(function ($query) use ($request) {
      if (isset($request->user))
        $query = $query->where('user', $request->user);
      if (isset($request->password))
        $query = $query->where('password', $request->password);
    })->get();

    if ($id) $model = Users::where('id', $id)->get();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 400);
    }

    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Usuário encontrado',
      ],
    ], 200);
  }

  public function update(Request $request, $id = null)
  {
    $model = Users::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('user', $request->user);
    })->first();

    if ($id) $model = Users::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Users::where('id', $model->id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Usuário atualizado',
      ]
    ], 200);
  }

  public function delete($id)
  {
    $model = Users::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 400);
    }

    Users::where('id', $id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Usuário deletado',
      ],
    ], 200);
  }
}
