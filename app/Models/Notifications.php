<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
  use SoftDeletes;

  protected $table = 'notifications';

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const TYPE = 'type';
  public const DOMAIN = 'domain';
  public const ACTION = 'action';
  public const DATA = 'data';

  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::TYPE,
    self::DOMAIN,
    self::ACTION,
    self::DATA,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::TYPE => 'string',
    self::DOMAIN => 'string',
    self::ACTION => 'string',
    self::DATA => 'json',
  ];

  protected $hidden = [
    self::ID_USER,
  ];
}
