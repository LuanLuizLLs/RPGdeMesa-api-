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
        ], 202);
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
      if (isset($request->name))
        $query = $query->where('name', $request->name);
      if (isset($request->password))
        $query = $query->where('password', $request->password);
    })->get();

    if ($id) $model = Users::where('id', $id)->get();

    if (empty($model->all())) {
      return response()->json([
        'response' => $model,
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 202);
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
        $query = $query->where('name', $request->name);
    })->first();

    if ($id) $model = Users::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'warning',
          'message' => 'Usuário não encontrado',
        ],
      ], 202);
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
}
