<?php
echo "retry: 60000\n";
echo ": keep-alive\n\n";

foreach ($sse as $values) {
  echo "id: ".$values['id']."\n";
  echo "event: ".$values['event']."\n";
  echo "data: ".$values['triggered_at']."\n";
  echo "retry: 60000\n";
  echo "\n\n";
}
