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

    protected $fillable = [
        self::ID,
        self::ID_USER,
        self::ID_ADVENTURE,
        self::ID_SCENARY,
        self::NAME,
        self::DESCRIPTION,
    ];

    protected $casts = [
        self::ID => 'integer',
        self::ID_USER => 'integer',
        self::ID_ADVENTURE => 'integer',
        self::ID_SCENARY => 'integer',
        self::NAME => 'string',
        self::DESCRIPTION => 'string',
    ];
}
