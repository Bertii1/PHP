<?php
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET["file_convegno"]) && !empty($_GET["file_convegno"])) {
  $filename = $_GET["file_convegno"];
  
  // Protezione: verifica che il file esista e sia nel percorso corretto
  $filepath = "../data/convegni/" . basename($filename);
  
  if (file_exists($filepath)) {
    $json = file_get_contents($filepath);
    $json = json_decode($json, true);
    
    if ($json && isset($json["partecipanti"])) {
      $res = "";
      for ($i = 0; $i < count($json["partecipanti"]); $i++) {
        $partecipante = $json["partecipanti"][$i];
        $res .= "<tr><td>" . htmlspecialchars($partecipante["nome"]) . "</td><td>" . htmlspecialchars($partecipante["cognome"]) . "</td></tr>\n";
      }
      echo $res;
    } else {
      http_response_code(500);
      echo "Errore: dati non validi";
    }
  } else {
    http_response_code(404);
    echo "Errore: file non trovato";
  }
} else {
  http_response_code(400);
  echo "Errore: parametro mancante";
}
?>
