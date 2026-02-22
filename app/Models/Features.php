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

  protected $appends = [
    'modifier',
  ];

  public function getModifierAttribute(): int
  {
    return array_sum([
      $this->strength,
      $this->dexterity,
      $this->constitution,
      $this->intelligence,
      $this->wisdom,
      $this->charisma,
    ]);
  }

  public function sumAttributes($id): object
  {
    return Features::where('id_character', $id)
      ->selectRaw('
        SUM(strength) as strength_total,
        SUM(dexterity) as dexterity_total,
        SUM(constitution) as constitution_total,
        SUM(intelligence) as intelligence_total,
        SUM(wisdom) as wisdom_total,
        SUM(charisma) as charisma_total
      ')
      ->first();
  }

  public function getUserId()
  {
    return $this
      ->select([$this->table . ".*", 'characters.id_user as id_user'])
      ->leftJoin('characters', $this->table . '.' . $this::ID_CHARACTER, '=', 'characters.id')
      ->value('id_user');
  }
}
