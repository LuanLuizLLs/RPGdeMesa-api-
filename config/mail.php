<?php

return [
  'driver' => env('MAIL_DRIVER', 'smtp'),
  'host' => env('MAIL_HOST', '127.0.0.1'),
  'port' => env('MAIL_PORT', 25),
  'from' => [
    'address' => env('MAIL_FROM_ADDRESS', 'contato@lls.app.br'),
    'site' => env('MAIL_FROM_SITE', 'https://rpg.lls.app.br'),
    'name' => env('MAIL_FROM_NAME', 'LLs'),
  ],
  'encryption' => env('MAIL_ENCRYPTION'),
  'username' => env('MAIL_USERNAME'),
  'password' => env('MAIL_PASSWORD'),
  'sendmail' => '/usr/sbin/sendmail -bs',
  'markdown' => [
    'theme' => 'default',
    'paths' => [],
  ],
];
