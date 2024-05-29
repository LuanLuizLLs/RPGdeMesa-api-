<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sse extends Model
{
  protected $table = 'sse';

  public const ID = 'id';
  public const EVENT = 'event';
  public const DATA = 'data';

  protected $fillable = [
    self::ID,
    self::EVENT,
    self::DATA,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::EVENT => 'string',
    self::DATA => 'string',
  ];
}
