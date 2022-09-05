<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abilities extends Model
{
    protected $table = 'abilities';

    public const MAX_LEVEL_ABILITY = 3;

    public const ID = 'id';
    public const ID_CHARACTER = 'id_character';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const ATTRIBUTE = 'attribute';
    public const LEVEL = 'level';
    public const CAPACITY = 'capacity';

    protected $fillable = [
        self::ID,
        self::ID_CHARACTER,
        self::NAME,
        self::DESCRIPTION,
        self::ATTRIBUTE,
        self::LEVEL,
        self::CAPACITY,
    ];

    protected $casts = [
        self::ID => 'integer',
        self::ID_CHARACTER => 'integer',
        self::NAME => 'string',
        self::DESCRIPTION => 'string',
        self::ATTRIBUTE => 'string',
        self::LEVEL => 'integer',
        self::CAPACITY => 'integer',
    ];

    public function getCapacity() {
      $character = Characters::where('id', $this->id_character)->first();
      
      if (empty($character)) {
        return ($character->intelligence + $character->wisdom + $character->charisma);
      }
      return 0;
    }
}
