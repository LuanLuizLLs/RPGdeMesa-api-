<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Characters extends Model
{
  use SoftDeletes;

  protected $table = 'characters';

  public const INITIAL_LIFE = 6;
  public const INITIAL_COINS = 3;
  public const INITIAL_ACTIONS = 3;
  public const INITIAL_STRENGTH = 1;
  public const INITIAL_DEXTERITY = 1;
  public const INITIAL_CONSTITUTION = 1;
  public const INITIAL_INTELLIGENCE = 1;
  public const INITIAL_WISDOW = 1;
  public const INITIAL_CHARISMA = 1;

  public const ID = 'id';
  public const ID_USER = 'id_user';
  public const ID_CAMPAIGN = 'id_campaign';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const LIFE = 'life';
  public const COINS = 'coins';
  public const ACTIONS = 'actions';
  public const STRENGTH = 'strength';
  public const DEXTERITY = 'dexterity';
  public const CONSTITUTION = 'constitution';
  public const INTELLIGENCE = 'intelligence';
  public const WISDOW = 'wisdom';
  public const CHARISMA = 'charisma';

  protected $fillable = [
    self::ID,
    self::ID_USER,
    self::ID_CAMPAIGN,
    self::NAME,
    self::DESCRIPTION,
    self::LIFE,
    self::COINS,
    self::ACTIONS,
    self::STRENGTH,
    self::DEXTERITY,
    self::CONSTITUTION,
    self::INTELLIGENCE,
    self::WISDOW,
    self::CHARISMA,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_USER => 'integer',
    self::ID_CAMPAIGN => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::LIFE => 'integer',
    self::COINS => 'integer',
    self::ACTIONS => 'integer',
    self::STRENGTH => 'integer',
    self::DEXTERITY => 'integer',
    self::CONSTITUTION => 'integer',
    self::INTELLIGENCE => 'integer',
    self::WISDOW => 'integer',
    self::CHARISMA => 'integer',
  ];

  protected $appends = [
    'capacity',
    'modified',
  ];

  public function getCapacityAttribute(): array
  {
    $attributes = $this->getModifiedAttribute();

    return [
      'life' => $this->lifeCapacity($attributes),
      'physical' => $this->physicalCapacity($attributes),
      'mental' => $this->mentalCapacity($attributes),
    ];
  }

  public function getModifiedAttribute(): array
  {
    $features = Features::sumAttributes($this->id);

    return [
      'strength' => (int) $features->strength_total + $this->strength,
      'dexterity' => (int) $features->dexterity_total + $this->dexterity,
      'constitution' => (int) $features->constitution_total + $this->constitution,
      'intelligence' => (int) $features->intelligence_total + $this->intelligence,
      'wisdom' => (int) $features->wisdom_total + $this->wisdom,
      'charisma' => (int) $features->charisma_total + $this->charisma,
    ];
  }

  public function lifeCapacity(array $character): int
  {
    return array_sum([
      $character['strength'],
      $character['dexterity'],
      $character['constitution'],
      $character['intelligence'],
      $character['wisdom'],
      $character['charisma'],
    ]);
  }

  public function physicalCapacity(array $character): int
  {
    return array_sum([
      $character['strength'],
      $character['dexterity'],
      $character['constitution'],
    ]);
  }

  public function mentalCapacity(array $character): int
  {
    return array_sum([
      $character['intelligence'],
      $character['wisdom'],
      $character['charisma'],
    ]);
  }

  static function reduceActions(int $id_character = 0, int $reduce = 0): void
  {
    $character = Characters::where('id', $id_character)->first();
    Characters::where('id', $id_character)->update([
      'actions' => $character->actions - $reduce,
    ]);
  }

  static function reduceCoins(int $id_character = 0, int $reduce = 0): void
  {
    $character = Characters::where('id', $id_character)->first();
    Characters::where('id', $id_character)->update([
      'coins' => $character->coins - $reduce,
    ]);
  }
}
