<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Explorations extends Model
{
  use SoftDeletes;

  protected $table = 'explorations';

  public const ID = 'id';
  public const ID_CAMPAIGN = 'id_campaign';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const HORIZONTAL = 'horizontal';
  public const VERTICAL = 'vertical';

  protected $fillable = [
    self::ID,
    self::ID_CAMPAIGN,
    self::NAME,
    self::DESCRIPTION,
    self::HORIZONTAL,
    self::VERTICAL,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CAMPAIGN => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::HORIZONTAL => 'integer',
    self::VERTICAL => 'integer',
  ];
}
