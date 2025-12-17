<?php

function returnFile($filename){
  $FilePath = "../".$filename . '.json';

  if (file_exists($FilePath)) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(file_get_contents($FilePath));
    return;
  }

  http_response_code(404);
  echo json_encode(['error' => 'il file non esiste']);
}

if (isset($_GET['file'])) {
  try {
    returnFile($_GET['file']);
  } catch (\Throwable $th) {
    http_response_code(500);
    error_log($th->getMessage());
    echo json_encode(['error' => 'Errore interno del server']);
  }
} else {
  http_response_code(400);
  echo json_encode(['error' => 'errore nella richiesta']);
}

?>