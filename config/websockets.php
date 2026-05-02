<?php

return [
  'apps' => [
    [
      'name' => env('APP_NAME'),
      'id' => env('PUSHER_APP_ID'),
      'key' => env('PUSHER_APP_KEY'),
      'secret' => env('PUSHER_APP_SECRET'),
      'path' => env('PUSHER_APP_PATH'),
      'capacity' => null,
      'enable_statistics' => false,
      'enable_client_messages' => false,
    ],
  ],
  'ssl' => [
    'local_pk' => null,
    'local_cert' => null,
    'passphrase' => null,
  ],
];
