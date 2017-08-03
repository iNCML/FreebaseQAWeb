<?php
function makeKey($userkey) {
  $key = hash_hmac('sha512', $userkey, 'a12');
  return $key;
}

function combineKeys($userkey, $serverKey)
{
  $n = strlen($userkey);
  $key = "";
  for($i = 0; $i < $n; $i++)
  {
    $key = $key . $userkey[$i];
    $key = $key . $serverKey[$i];
  }
  return $key;
}

?>
