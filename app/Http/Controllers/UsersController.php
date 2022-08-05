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
          'status' => 'warning',
          'message' => 'Usuário já existe',
        ], 400);
      }

    $model = new Users();
    $model->user = $request->user;
    $model->password = $request->password;
    $model->save();

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário criado com sucesso',
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

    return response()->json([
      'response' => $model,
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
        'status' => 'warning',
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    Users::where('id', $model->id)->update([
      'user' => $request->user,
      'password' => $request->password,
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário atualizado com sucesso',
    ], 200);
  }

  public function delete($id)
  {
    $model = Users::where('id', $id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Usuário não encontrado',
      ], 400);
    }

    Users::where('id', $id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário deletado com sucesso',
    ], 200);
  }
}
