<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Characters;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
  function create(Request $request)
  {
    $character = Characters::where('id', $request->id_character)->first();
    $quantity_items = Items::quantityItems($request->id_character);

    if (empty($character)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Personagem não encontrado',
      ], 400);
    }

    if ($quantity_items >= $character->capacity['physical']) {
      return response()->json([
        'status' => 'error',
        'message' => 'Capacidade de itens atingida',
      ], 400);
    }

    if ($request->level > Items::MAX_LEVEL_ITEMS) {
      return response()->json([
        'status' => 'error',
        'message' => 'Item atingiu o nível máximo',
      ], 400);
    }

    $model = new Items();
    $data = array_intersect_key($request->all(), $model->getCasts());
    $model->create($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Item criado',
    ], 200);
  }

  public function read(Request $request)
  {
    $model = Items::select()
      ->where(function ($query) use ($request) {
        if (isset($request->id))
          $query = $query->where('id', $request->id);
        if (isset($request->id_character))
          $query = $query->where('id_character', $request->id_character);
      })
      ->get();

    if (empty($model->all())) {
      return response()->json([
        'status' => 'warning',
        'message' => 'Item não encontrado',
        'response' => $model,
      ], 202);
    }

    return response()->json([
      'status' => 'error',
      'message' => 'Item encontrado',
      'response' => $model,
    ], 200);
  }

  public function update(Request $request)
  {
    $model = Items::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Item não encontrado',
      ], 400);
    }

    if ($request->level > Items::MAX_LEVEL_ITEMS) {
      return response()->json([
        'status' => 'error',
        'message' => 'Item atingiu o nível máximo',
      ], 400);
    }

    $data = array_intersect_key($request->all(), $model->getCasts());
    Items::where('id', $request->id)->update($data);

    return response()->json([
      'status' => 'success',
      'message' => 'Item atualizado',
    ], 200);
  }

  public function delete(Request $request)
  {
    $model = Items::where('id', $request->id)->first();

    if (empty($model)) {
      return response()->json([
        'status' => 'error',
        'message' => 'Item não encontrado',
      ], 400);
    }

    Items::where('id', $request->id)->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Item deletado',
    ], 200);
  }
}
