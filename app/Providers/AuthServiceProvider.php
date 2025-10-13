<?php

namespace App\Providers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {}

  /**
   * Boot the authentication services for the application.
   *
   * @return void
   */
  public function boot()
  {
    try {
      if ($user = JWTAuth::parseToken()->authenticate()) {
        return $user;
      }
    } catch (\Exception $e) {
      return null;
    }
    return null;
  }
}
