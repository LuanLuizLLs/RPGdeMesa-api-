<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
  protected $table = 'inventory';

  public const MAX_LEVEL_ITEMS = 3;

  public const ID = 'id';
  public const ID_CHARACTER = 'id_character';
  public const NAME = 'name';
  public const DESCRIPTION = 'description';
  public const USABLE = 'usable';
  public const ATTRIBUTE = 'attribute';
  public const LEVEL = 'level';

  protected $fillable = [
    self::ID,
    self::ID_CHARACTER,
    self::NAME,
    self::DESCRIPTION,
    self::USABLE,
    self::ATTRIBUTE,
    self::LEVEL,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::ID_CHARACTER => 'integer',
    self::NAME => 'string',
    self::DESCRIPTION => 'string',
    self::USABLE => 'boolean',
    self::ATTRIBUTE => 'string',
    self::LEVEL => 'integer',
  ];

  static public function getQuantityItems($id_character, $quantity = 0)
  {
    $items = Inventory::where('id_character', $id_character)->get();
    
    foreach ($items->all() as $item) {
      $quantity += $item->level;
    }
    return $quantity;
  }
}
