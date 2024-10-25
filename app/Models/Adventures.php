<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adventures extends Model
{
  use SoftDeletes;

  protected $table = 'adventures';

  public const ID = 'id';
  public const ID_CAMPAIGN = 'id_campaign';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const GOAL = 'goal';
  public const REWARD = 'reward';

  protected $fillable = [
    self::ID,
    self::ID_CAMPAIGN,
    self::NAME,
    self::DESCRIPTION,
    self::GOAL,
    self::REWARD,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CAMPAIGN => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::GOAL => 'string',
    self::REWARD => 'string',
  ];
}
