<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\UsersAuthenticator;
use App\Services\RecoverPasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  use RecoverPasswordService;

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
      'response' => $user,
    ], 202);
  }

  public function register(Request $request)
  {
    $model = Users::where('username', $request->username)
      ->orWhere('email', $request->email)
      ->first();

    if ($model) {
      return response()->json([
        'status' => 'error',
        'message' => 'Não autorizado',
      ], 401);
    }

    Users::create([
      'email' => $request->email,
      'username' => $request->username,
      'password' => Hash::make($request->password),
    ]);

    return response()->json([
      'status' => 'success',
      'message' => 'Usuário criado',
    ], 200);
  }

  public function sendCode(Request $request)
  {
    $model = Users::where('email', $request->email)->first();

    if (is_null($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Usuário não encontrado',
      ], 401);
    }

    $sent = $this->sendCodeInEmail($model);

    if ($sent) {
      return response()->json([
        'status' => 'info',
        'message' => 'Código enviado com sucesso',
      ], 200);
    }

    return response()->json([
      'status' => 'error',
      'message' => 'Erro ao enviar o código',
    ], 400);
  }

  public function confirmCode(Request $request)
  {
    $model = UsersAuthenticator::where(UsersAuthenticator::CODE, $request->code)->first();

    if (is_null($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Não autorizado',
      ], 401);
    }

    $user = Users::where(Users::ID, $model->id_user)->first();
    $token = $this->generateTemporaryToken($user);

    if ($token) {
      return response()->json([
        'status' => 'info',
        'message' => 'Token gerado com sucesso',
        'token' => $token,
      ], 200);
    }

    return response()->json([
      'status' => 'error',
      'message' => 'Erro ao gerar o token',
    ], 400);
  }

  public function recover(Request $request)
  {
    /**
     * @var \App\Models\Users
     */
    $user = auth()->user();

    if (is_null($user)) {
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

    UsersAuthenticator::where('id_user', $user->id)->delete();

    $user->update([
      'password' => Hash::make($request->password),
    ]);

    auth()->logout();

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
