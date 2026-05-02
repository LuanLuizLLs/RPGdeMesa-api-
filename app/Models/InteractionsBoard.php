<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteractionsBoard extends Model
{
  protected $table = 'interactions_board';

  public const ID = 'id';
  public const ID_INTERACTION = 'id_interaction';
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
    self::ID_INTERACTION,
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
    self::ID_INTERACTION => 'integer',
    self::LIFE => 'integer',
    self::MODIFIER => 'integer',
    self::STRENGTH => 'integer',
    self::DEXTERITY => 'integer',
    self::CONSTITUTION => 'integer',
    self::INTELLIGENCE => 'integer',
    self::WISDOW => 'integer',
    self::CHARISMA => 'integer',
  ];

  public function shape()
  {
    return $this->belongsTo(Interactions::class, 'id_interaction', 'id');
  }

  public function getIdAdventure()
  {
    return $this
      ->select('interactions.id_adventure')
      ->leftJoin('interactions', 'interactions.id', '=', 'interactions_board.id_interaction')
      ->value('id_adventure');
  }
}
