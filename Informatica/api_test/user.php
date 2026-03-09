<?php

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

$users = [
  ["id" => 1, "nome" => "mario rossi", "email" => "mario@example.com"],
  ["id" => 2, "nome" => "luigi verdi", "email" => "luigi@example.com"]
];

if ($method == "GET") {
  echo json_encode($users);
} else {
  http_response_code(405);
  echo json_encode(["error" => "metodo non supportato"]);
}