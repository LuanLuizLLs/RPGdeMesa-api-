<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scenarios extends Model
{
  use SoftDeletes;

  protected $table = 'scenarios';

  public const ID = 'id';
  public const ID_CAMPAIGN = 'id_campaign';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const REGION = 'region';
  public const CULTURE = 'culture';

  protected $fillable = [
    self::ID,
    self::ID_CAMPAIGN,
    self::NAME,
    self::DESCRIPTION,
    self::REGION,
    self::CULTURE,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CAMPAIGN => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::REGION => 'string',
    self::CULTURE => 'string',
  ];
}
