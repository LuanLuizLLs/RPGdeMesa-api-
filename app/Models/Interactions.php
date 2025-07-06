<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interactions extends Model
{
  use SoftDeletes;

  protected $table = 'interactions';

  public const ID = 'id';
  public const ID_ADVENTURE = 'id_adventure';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const LIFE = 'life';
  public const MODIFIER = 'modifier';
  public const STRENGTH = 'strength';
  public const DEXTERITY = 'dexterity';
  public const CONSTITUTION = 'constitution';
  public const INTELLIGENCE = 'intelligence';
  public const WISDOW = 'wisdom';
  public const CHARISMA = 'charisma';

  protected $fillable = [
    self::ID,
    self::ID_ADVENTURE,
    self::NAME,
    self::DESCRIPTION,
    self::LIFE,
    self::MODIFIER,
    self::STRENGTH,
    self::DEXTERITY,
    self::CONSTITUTION,
    self::INTELLIGENCE,
    self::WISDOW,
    self::CHARISMA,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_ADVENTURE => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::LIFE => 'integer',
    self::MODIFIER => 'integer',
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
