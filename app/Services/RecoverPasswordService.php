<?php

namespace App\Services;

use App\Mails\RecoverPasswordMail;
use App\Models\Users;
use App\Models\UsersAuthenticator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

trait RecoverPasswordService
{
  private $code = '';

  private static $CODE_LENGHT = 6;
  private static $CODE_MAX_LENGHT = 33;
  private static $CHARACTERS = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';

  private function generateCode(): string
  {
    $code = '';

    for ($i = 0; $i < self::$CODE_LENGHT; $i++) {
      $code .= self::$CHARACTERS[random_int(0, self::$CODE_MAX_LENGHT)];
    }

    return $code;
  }

  public function sendCodeInEmail(Users $user): bool
  {
    do {
      $this->code = $this->generateCode();
      $codeExists = UsersAuthenticator::where(UsersAuthenticator::CODE, $this->code)->exists();
    } while ($codeExists);

    try {
      $created = UsersAuthenticator::create([
        UsersAuthenticator::ID_USER => $user->id,
        UsersAuthenticator::CODE => $this->code,
      ]);

      if ($created) {
        $content = new RecoverPasswordMail(
          $user->username,
          $this->code,
        );

        Mail::to($user->email)->send($content);

        return true;
      }

      return false;
    } catch (\Exception $_) {
      return false;
    }
  }

  public function generateTemporaryToken(Users $user): string
  {
    return JWTAuth::fromUser($user);
  }
}
