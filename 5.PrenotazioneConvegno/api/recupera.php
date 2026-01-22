<?php
if (isset($_GET["file_convegno"])) {
  $filename = $_GET["file_convegno"];
  $json = file_get_contents("../data/convegni/" . $filename);
  if ($json) {
    http_response_code(200);
    echo $json;
  } else {
    http_response_code(500);
    echo "{errore:'file non trovato',codice_errore:500}";
  }

} elseif (isset($_GET["lista_convegni"])) {

  $files = scandir("../data/convegni");
  $res = "[";
  for ($i = 0; $i < count($files); $i++) {
    $filename = preg_replace('/[_]/', ' ', pathinfo($files[$i], PATHINFO_FILENAME));
    if (strlen($filename) > 2) {
        $res .= "{\"name\":\"" . $filename . "\",\"filename\":\"" . $files[$i] . "\"},"; 
    }
  }
  $res = rtrim($res, ",") . "]";
  echo $res;
}
?>