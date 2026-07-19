<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersAuthenticator extends Model
{
  use SoftDeletes;

  protected $table = 'users_authenticator';

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const CODE = 'code';

  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::CODE,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::CODE => 'string',
  ];

  protected $hidden = [
    self::CODE,
  ];
}
