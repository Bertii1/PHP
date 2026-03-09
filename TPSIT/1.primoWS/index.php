<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "Tpsit", "password", "TPSIT");

if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Database connection failed"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
  if (isset($_GET["nome_utente"]) && $_GET["nome_utente"] !== "") {
    $nome_utente = $_GET["nome_utente"];
    $stmnt = $conn->prepare("SELECT id, nome, email FROM users WHERE nome = ?");
    $stmnt->bind_param("s", $nome_utente);
    $stmnt->execute();
    $res = $stmnt->get_result();
    if ($res !== false) {
      $results = [];
      while ($row = $res->fetch_assoc()) {
        $results[] = ["id" => $row["id"], "nome" => $row["nome"], "email" => $row["email"]];
      }
      echo json_encode($results);
    } else {
      http_response_code(500);
      echo json_encode(["error" => "Query execution failed"]);
    }
    $stmnt->close();
  } else {
    http_response_code(400);
    echo json_encode(["error" => "Parametro nome_utente mancante o vuoto"]);
  }

} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
  $input = json_decode(file_get_contents('php://input'), true);
  $nome_utente = $input['nome_utente'] ?? $_POST['nome_utente'] ?? $_GET['nome_utente'] ?? '';
  $email = $input['email'] ?? $_POST['email'] ?? $_GET['email'] ?? '';

  if (!empty($nome_utente) && !empty($email)) {
    $stmnt = $conn->prepare("INSERT INTO users (nome, email) VALUES (?, ?)");
    $stmnt->bind_param("ss", $nome_utente, $email);
    if ($stmnt->execute()) {
      echo json_encode(["success" => "Utente inserito con successo"]);
    } else {
      http_response_code(500);
      echo json_encode(["error" => "Inserimento fallito"]);
    }
    $stmnt->close();
  } else {
    http_response_code(400);
    echo json_encode(["error" => "Parametri nome_utente ed email richiesti"]);
  }

} else {
  http_response_code(405);
  echo json_encode(["error" => "Metodo HTTP non supportato"]);
}

$conn->close();