<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interactions extends Model
{
  protected $table = 'interactions';

  public const ID = 'id';
  public const ID_CAMPAIGN = 'id_campaign';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const LIFE = 'life';
  public const DAMAGE = 'damage';
  public const STRENGTH = 'strength';
  public const DEXTERITY = 'dexterity';
  public const CONSTITUTION = 'constitution';
  public const INTELLIGENCE = 'intelligence';
  public const WISDOW = 'wisdom';
  public const CHARISMA = 'charisma';

  protected $fillable = [
    self::ID,
    self::ID_CAMPAIGN,
    self::NAME,
    self::DESCRIPTION,
    self::LIFE,
    self::DAMAGE,
    self::STRENGTH,
    self::DEXTERITY,
    self::CONSTITUTION,
    self::INTELLIGENCE,
    self::WISDOW,
    self::CHARISMA,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CAMPAIGN => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::LIFE => 'integer',
    self::DAMAGE => 'integer',
    self::STRENGTH => 'integer',
    self::DEXTERITY => 'integer',
    self::CONSTITUTION => 'integer',
    self::INTELLIGENCE => 'integer',
    self::WISDOW => 'integer',
    self::CHARISMA => 'integer',
  ];

  protected $appends = [
    'level',
  ];

  public function getLevelAttribute()
  {
    $level = ($this->life * 0.1) + $this->damage;
    $level += $this->strength + $this->dexterity + $this->constitution + $this->intelligence + $this->wisdom + $this->charisma;
    return ceil($level / 6);
  }
}
