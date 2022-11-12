<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Characters;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
  /**
   * Controller Inventory
   */

  function create(Request $request)
  {
    $character = Characters::where('id', $request->id_character)->first();
    $quantity_items = Inventory::getQuantityItems($request->id_character, $request->level);
    
    if (empty($character)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Personagem não encontrado',
        ],
      ], 400);
    }

    if($quantity_items > $character->getPhysicalCapacity()) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Capacidade de itens atingida',
        ],
      ], 400);
    }

    if ($request->user === $character->id_user)
      if ($character->actions < 1) {
        return response()->json([
          'message' => [
            'type' => 'error',
            'message' => 'Personagem não possui ações',
          ],
        ], 400);
      } elseif ($request->user === $character->id_user) {
        Characters::getReduceActions($request->id_character);
      }

    $model = new Inventory();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Item criado',
      ],
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Inventory::select()->where(function ($query) use ($request) {
      if (isset($request->id))
        $query = $query->where('id', $request->id);
      if (isset($request->id_character))
        $query = $query->where('id_character', $request->id_character);
    })->get();

    if (empty($model->all())) {
      return response()->json([
        'response' => $model,
        'message' => [
          'type' => 'warning',
          'message' => 'Item não encontrado',
        ]
      ], 202);
    }
    
    return response()->json([
      'response' => $model,
      'message' => [
        'type' => 'success',
        'message' => 'Item encontrado',
      ],
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Inventory::where('id', $request->id)->first();
    $character = Characters::where('id', $model->id_character)->first();
    $quantity_items = Inventory::getQuantityItems($model->id_character);

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Item não encontrado',
        ],
      ], 400);
    }

    if($quantity_items >= $character->getPhysicalCapacity()) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Capacidade de itens atingida',
        ],
      ], 400);
    }

    if ($request->user === $character->id_user)
      if ($character->actions < 1) {
        return response()->json([
          'message' => [
            'type' => 'error',
            'message' => 'Personagem não possui ações',
          ],
        ], 400);
      } elseif ($request->user === $character->id_user) {
        if ($request->level > Inventory::MAX_LEVEL_ITEMS) {
          return response()->json([
            'message' => [
              'type' => 'error',
              'message' => 'Item atingiu o nível máximo',
            ],
          ], 400);
        }
        Characters::getReduceActions($model->id_character);
      }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Inventory::where('id', $request->id)->update($data);

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Item atualizado',
      ],
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Inventory::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'message' => [
          'type' => 'error',
          'message' => 'Item não encontrado',
        ],
      ], 400);
    }

    if ($request->usage) {
      Characters::getReduceActions($model->id_character);
    }

    Inventory::where('id', $request->id)->delete();

    return response()->json([
      'message' => [
        'type' => 'success',
        'message' => 'Item deletado',
      ],
    ], 200);
  }
}
