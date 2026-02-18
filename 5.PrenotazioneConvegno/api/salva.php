<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  if ($_SESSION["tipo_utente"] == "admin") {
    $json_file = file_get_contents('php://input');
    $json = json_decode($json_file);

    if ($json && !empty($json->nome_convegno)) {
      $filename = "../data/convegni/" . preg_replace('/[^a-zA-Z0-9_-]/', '_', $json->nome_convegno) . ".json";
      $new_json = fopen($filename, "w");

      if ($new_json) {
        fwrite($new_json, $json_file);
        fclose($new_json);
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Dati salvati con successo"]);
      } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Errore nella creazione del file"]);
      }
    } else {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Dati non validi"]);
    }
  } else {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "unauthorized"]);
  }
}
?>