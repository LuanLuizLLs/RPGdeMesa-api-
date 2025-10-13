<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Model implements AuthorizableContract, AuthenticatableContract, JWTSubject
{
  use SoftDeletes, Authenticatable, Authorizable, HasFactory;

  protected $table = 'users';

  public const ID = 'id';
  public const USERNAME = 'username';
  public const PASSWORD = 'password';

  protected $fillable = [
    self::ID,
    self::USERNAME,
    self::PASSWORD,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::USERNAME => 'string',
    self::PASSWORD => 'string',
  ];

  protected $hidden = [
    self::PASSWORD,
  ];

  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
    return [];
  }
}
