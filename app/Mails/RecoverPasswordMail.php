<?php

namespace App\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPasswordMail extends Mailable
{
  use SerializesModels;

  public $user = '';
  public $code = '';

  public function __construct(string $user, int $code)
  {
    $this->user = $user;
    $this->code = $code;
  }

  public function build()
  {
    return $this
      ->from(config('mail.from.address'), config('mail.from.name'))
      ->subject('Recuperação de Senha - RPG de Mesa')
      ->view('mails.recover-password')
      ->with([
        'user' => $this->user,
        'code' => $this->code,
      ]);
  }
}
