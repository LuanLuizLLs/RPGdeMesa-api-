<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Jwt
{
  public function handle($request, Closure $next)
  {
    try {
      JWTAuth::parseToken()->authenticate();
    } catch (TokenExpiredException $e) {
      return response()->json([
        'status' => 'error',
        'message' => 'Token expirado'
      ], 401);
    } catch (TokenInvalidException $e) {
      return response()->json([
        'status' => 'error',
        'message' => 'Token inválido'
      ], 401);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => 'Token não enviado'
      ], 401);
    }

    return $next($request);
  }
}
