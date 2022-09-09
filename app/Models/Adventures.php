<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adventures extends Model
{
  protected $table = 'adventures';

  public const ID = 'id';
  public const ID_CAMPAIGN = 'id_campaign';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';

  protected $fillable = [
    self::ID,
    self::ID_CAMPAIGN,
    self::NAME,
    self::DESCRIPTION,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CAMPAIGN => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
  ];
}
