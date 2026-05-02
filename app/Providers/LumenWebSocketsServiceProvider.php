<?php

namespace App\Providers;

use BeyondCode\LaravelWebSockets\WebSocketsServiceProvider;

class LumenWebSocketsServiceProvider extends WebSocketsServiceProvider
{
  /**
   * Sobrescrevemos métodos para impedir que o pacote 
   * tente usar o Router do Laravel que não existe no Lumen.
   * 
   * @return void
   */
  public function boot()
  {
    return;
  }
}
