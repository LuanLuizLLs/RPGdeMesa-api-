<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characters extends Model
{
    protected $table = 'characters';

    public const ID = 'id';
    public const ID_USER = 'id_user';
    public const ID_CAMPAING = 'id_campaing';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const RACE = 'race';
    public const CASTE = 'caste';
    public const TENDENCY = 'tendency';
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
        self::ID_CAMPAING,
        self::NAME,
        self::DESCRIPTION,
        self::RACE,
        self::CASTE,
        self::TENDENCY,
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
        self::ID_CAMPAING => 'integer',
        self::NAME => 'string',
        self::DESCRIPTION => 'string',
        self::RACE => 'string',
        self::CASTE => 'string',
        self::TENDENCY => 'string',
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
}
