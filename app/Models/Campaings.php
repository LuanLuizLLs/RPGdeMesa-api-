<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaings extends Model
{
    protected $table = 'campaigns';

    public const ID = 'id';
    public const ID_USER = 'id_user';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';

    protected $fillable = [
        self::ID,
        self::ID_USER,
        self::NAME,
        self::DESCRIPTION,
    ];

    protected $casts = [
        self::ID => 'integer',
        self::ID_USER => 'integer',
        self::NAME => 'string',
        self::DESCRIPTION => 'string',
    ];
}
