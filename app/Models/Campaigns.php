<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
  protected $table = 'campaigns';

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const ID_ADVENTURE = 'id_adventure';
  public const ID_SCENERY = 'id_scenery';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const PERIOD = 'period';
  public const SEASON = 'season';
  public const GROUND = 'ground';
  public const RESOURCES = 'resources';
  public const CLIMATE = 'climate';
  
  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::ID_ADVENTURE,
    self::ID_SCENERY,
    self::NAME,
    self::DESCRIPTION,
    self::PERIOD,
    self::SEASON,
    self::GROUND,
    self::RESOURCES,
    self::CLIMATE,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::ID_ADVENTURE => 'integer',
    self::ID_SCENERY => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::PERIOD => 'string',
    self::SEASON => 'string',
    self::GROUND => 'integer',
    self::RESOURCES => 'integer',
    self::CLIMATE => 'integer',
  ];
}
