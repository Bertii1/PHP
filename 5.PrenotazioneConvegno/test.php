<?php
require_once __DIR__ . "/includes/db.php";
global $conn;
$nome_convegno = "volta in progress";
$res = execute_query($conn, "SELECT id FROM Convegni where nome_convegno='" . $nome_convegno . "'");
foreach ($res as $row) {
  var_dump($row);

}