<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    public const ID = 'id';
    public const USER = 'user';
    public const PASSWORD = 'password';

    protected $fillable = [
        self::ID,
        self::USER,
        self::PASSWORD,
    ];

    protected $casts = [
        self::ID => 'integer',
        self::USER => 'string',
        self::PASSWORD => 'string',
    ];
}
