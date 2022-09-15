<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
  protected $table = 'campaigns';

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const ID_ADVENTURE = 'id_adventure';
  public const ID_SCENARY = 'id_scenary';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const PERIOD = 'period';
  public const SEASON = 'season';
  public const GROUND = 'ground';
  public const RESOURCES = 'resources';
  public const LIGHTING = 'lighting';
  public const TEMPERATURE = 'temperature';
  public const WIND = 'wind';
  public const PRECIPITATION = 'precipitation';
  
  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::ID_ADVENTURE,
    self::ID_SCENARY,
    self::NAME,
    self::DESCRIPTION,
    self::PERIOD,
    self::SEASON,
    self::GROUND,
    self::RESOURCES,
    self::LIGHTING,
    self::TEMPERATURE,
    self::WIND,
    self::PRECIPITATION,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::ID_ADVENTURE => 'integer',
    self::ID_SCENARY => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::PERIOD => 'string',
    self::SEASON => 'string',
    self::GROUND => 'integer',
    self::RESOURCES => 'integer',
    self::LIGHTING => 'integer',
    self::TEMPERATURE => 'integer',
    self::WIND => 'integer',
    self::PRECIPITATION => 'integer',
  ];
}
