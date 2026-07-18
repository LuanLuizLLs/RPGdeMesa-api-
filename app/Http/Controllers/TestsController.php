<?php

namespace App\Http\Controllers;

use App\Mails\RecoverPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestsController extends Controller
{
  public function mails(Request $request, string $content)
  {
    $mail = [
      'recover-password' => new RecoverPasswordMail(
        'LLs',
        '123ABC'
      )
    ];

    Mail::to($request->email)->send($mail[$content]);
  }

  public function views(string $path, string $view)
  {
    $data = [
      'recover-password' => [
        'user' => 'LLs',
        'code' => '123ABC',
      ]
    ];

    return view($path . '.' . $view, $data[$view]);
  }
}
