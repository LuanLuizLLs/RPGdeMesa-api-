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

    protected $fillable = [
        self::ID,
        self::ID_CHARACTER,
        self::NAME,
        self::DESCRIPTION,
        self::ATTRIBUTE,
        self::LEVEL,
    ];

    protected $casts = [
        self::ID => 'integer',
        self::ID_CHARACTER => 'integer',
        self::NAME => 'string',
        self::DESCRIPTION => 'string',
        self::ATTRIBUTE => 'string',
        self::LEVEL => 'integer',
    ];
}
