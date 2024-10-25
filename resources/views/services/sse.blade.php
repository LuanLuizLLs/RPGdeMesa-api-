<?php

foreach ($sse as $values) {
  echo "id: ".$values['id']."\n";
  echo "event: ".$values['event']."\n";
  echo "data: ".json_decode($values['data'])."\n";
  echo "retry: 10000\n";
  echo "\n\n";
}
