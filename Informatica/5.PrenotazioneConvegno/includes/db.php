<?php
require_once __DIR__ . "/config.php";

$conn = new mysqli($hostname, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
  die("Errore di connessione: " . $conn->connect_error);
}

function execute_query($conn, $query)
{
  $result = $conn->query($query);
  if ($result) {
    return $result;
  } else {
    return false;
  }
}
