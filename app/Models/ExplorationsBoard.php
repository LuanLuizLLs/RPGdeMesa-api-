<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExplorationsBoard extends Model
{
  protected $table = 'explorations_board';

  public const ID = 'id';
  public const ID_EXPLORATION = 'id_exploration';
  public const ACTIVE = 'active';
  public const BOARD = 'board';

  protected $fillable = [
    self::ID,
    self::ID_EXPLORATION,
    self::ACTIVE,
    self::BOARD,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_EXPLORATION => 'integer',
    self::ACTIVE => 'boolean',
    self::BOARD => 'json',
  ];

  public function getIdScenery()
  {
    return $this
      ->select('explorations.id_scenery')
      ->leftJoin('explorations', 'explorations.id', '=', 'explorations_board.id_exploration')
      ->value('id_scenery');
  }
}
