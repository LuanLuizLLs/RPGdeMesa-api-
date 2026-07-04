<?php

namespace App\Http\Controllers;

use App\Mails\RecoverPasswordMail;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailsController extends Controller
{
  public function index(Request $request, string $content)
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
}
