<?php

namespace App\Http\Controllers;

use App\Mails\RecoverPasswordMail;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestsController extends Controller
{
  public function mails(Request $request, string $content)
  {
    $faker = Factory::create();

    $mail = [
      'recover-password' => new RecoverPasswordMail(
        $faker->name(),
        $faker->numberBetween(100000, 999999)
      )
    ];

    Mail::to($request->email)->send($mail[$content]);
  }

  public function views(string $path, string $view)
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
