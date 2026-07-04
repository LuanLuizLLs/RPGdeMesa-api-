<?php

namespace App\Http\Controllers;

use Faker\Factory;

class ViewsController extends Controller
{
  public function index(string $path, string $view)
  {
    $faker = Factory::create();

    $data = [
      'recover-password' => [
        'user' => $faker->name(),
        'code' => $faker->numberBetween(100000, 999999),
      ]
    ];

    return view($path . '.' . $view, $data[$view]);
  }
}
