<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function me()
  {
    if (!$user = auth()->user()) {
      return response()->json([
        'status' => 'error',
        'message' => 'Não autorizado',
      ], 401);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário encontrado',
      'response' => $user
    ], 202);
  }

  public function register(Request $request)
  {
    $model = Users::where('username', $request->username)->first();

    if ($model) {
      return response()->json([
        'status' => 'error',
        'message' => 'Não autorizado',
      ], 401);
    }

    Users::create([
      'username' => $request->username,
      'password' => Hash::make($request->password),
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário criado',
    ], 200);
  }

  public function recover(Request $request)
  {
    $model = Users::where('username', $request->username)->first();

    if (!$model) {
      return response()->json([
        'status' => 'error',
        'message' => 'Não autorizado',
      ], 401);
    }

    if ($request->password != $request->new_password) {
      return response()->json([
        'status' => 'error',
        'message' => 'Senha inválida',
      ], 400);
    }

    $model->update([
      'password' => Hash::make($request->password),
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Senha alterada',
    ], 200);
  }

  public function login()
  {
    $credentials = request(['username', 'password']);

    if (!$token = auth()->attempt($credentials)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Não autorizado',
      ], 401);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Login realizado',
      'response' => auth()->user(),
      'token' => $token,
    ], 202);
  }

  public function logout()
  {
    auth()->logout();
    return response()->json([
      'status' => 'success',
      'message' => 'Logout realizado'
    ], 202);
  }
}
