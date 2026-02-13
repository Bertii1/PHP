<?php
$server = "localhost";
$user = "GestioneConvegni_app";
$db_password = "ciaodario";
$dbname = "GestioneConvegni";

function execute_query($conn, $query)
{
  if ($conn->query($query) === true) {
    echo "query eseguita\n";
  } else {
    echo "errore nell esecuzione della query: " . $conn->error . "\n";
  }
}

//definizione connessione al DataBase
$conn = new mysqli($server, $user, $db_password, $dbname);

//controlla se la connessione al DataBase è andata a buon fine
if ($conn->connect_error) {
  die("errore di connessione: " . $conn->connect_error . "\n");
} else {
  echo "connected to DB\n";
}

//eseguo una query per vedere se il DataBase esiste e se no lo creo
$query = "CREATE TABLE IF NOT EXISTS Utenti (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    tipo VARCHAR(6) NOT NULL
)";

execute_query($conn, $query);

$json = file_get_contents("utenti.json");
$json = json_decode($json, true);

$query = "";

for ($i = 0; $i < count($json); $i++) {
  $id = $json[$i]["id"];
  $nome_utente = $json[$i]["utente"];
  $password_utente = $json[$i]["password"];
  $tipo = $json[$i]["tipo"];

  $query = "INSERT INTO Utenti (id, username, password, tipo) VALUES ('"
    . $id . "', '"
    . $nome_utente . "', '"
    . $password_utente . "', '"
    . $tipo . "');";

  execute_query($conn, $query);
}
