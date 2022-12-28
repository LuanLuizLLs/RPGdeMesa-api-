<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaigns extends Model
{
  use SoftDeletes;

  protected $table = 'campaigns';

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const ID_ADVENTURE = 'id_adventure';
  public const ID_SCENERY = 'id_scenery';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const PERIOD = 'period';
  public const CLIMATE = 'climate';
  public const GROUND = 'ground';
  public const RESOURCES = 'resources';
  
  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::ID_ADVENTURE,
    self::ID_SCENERY,
    self::NAME,
    self::DESCRIPTION,
    self::PERIOD,
    self::CLIMATE,
    self::GROUND,
    self::RESOURCES,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::ID_ADVENTURE => 'integer',
    self::ID_SCENERY => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::PERIOD => 'string',
    self::CLIMATE => 'string',
    self::GROUND => 'integer',
    self::RESOURCES => 'integer',
  ];
}
