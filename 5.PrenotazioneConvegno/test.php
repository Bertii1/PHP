<?php

function execute_query($conn, $query)
{
  $result = $conn->query($query);
  if ($result) {
    echo "query eseguita\n";
    return $result;
  } else {
    echo "errore nell'esecuzione della query: " . $conn->error . "\n";
    return false;
  }
}