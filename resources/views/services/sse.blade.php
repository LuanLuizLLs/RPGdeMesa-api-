<?php

foreach ($sse as $values) {
  echo "id: ".$values['id']."\n";
  echo "event: ".$values['event']."\n";
  echo "data: ".json_decode($values['data'])."\n";
  echo "\n\n";
}
