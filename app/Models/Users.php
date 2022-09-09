<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
  protected $table = 'users';

  public const ID = 'id';
  public const NAME = 'name';
  public const PASSWORD = 'password';

  protected $fillable = [
    self::ID,
    self::NAME,
    self::PASSWORD,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::NAME => 'string',
    self::PASSWORD => 'string',
  ];

  protected $hidden = [
    self::PASSWORD,
  ];
}
