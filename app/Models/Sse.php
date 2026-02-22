<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sse extends Model
{
  protected $table = 'sse';

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const EVENT = 'event';
  public const TRIGGERED_AT = 'triggered_at';

  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::EVENT,
    self::TRIGGERED_AT,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::EVENT => 'string',
    self::TRIGGERED_AT => 'datetime',
  ];
}
