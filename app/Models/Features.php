<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
  protected $table = 'features';

  public const ID = 'id';
  public const ID_CHARACTER = 'id_character';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const STRENGTH = 'strength';
  public const DEXTERITY = 'dexterity';
  public const CONSTITUTION = 'constitution';
  public const INTELLIGENCE = 'intelligence';
  public const WISDOW = 'wisdom';
  public const CHARISMA = 'charisma';

  protected $fillable = [
    self::ID,
    self::ID_CHARACTER,
    self::NAME,
    self::DESCRIPTION,
    self::STRENGTH,
    self::DEXTERITY,
    self::CONSTITUTION,
    self::INTELLIGENCE,
    self::WISDOW,
    self::CHARISMA,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CHARACTER => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::STRENGTH => 'integer',
    self::DEXTERITY => 'integer',
    self::CONSTITUTION => 'integer',
    self::INTELLIGENCE => 'integer',
    self::WISDOW => 'integer',
    self::CHARISMA => 'integer',
  ];
}
