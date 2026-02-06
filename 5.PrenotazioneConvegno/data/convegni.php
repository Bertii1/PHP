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

$query = "CREATE TABLE IF NOT EXISTS Convegni(
id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
nome_convegno VARCHAR(50) NOT NULL,
numero_partecipanti INT(6)";

execute_query($conn, $query);

$query = "CREATE TABLE IF NOT EXISTS Partecipanti(
id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
id_convegno INT(6) NOT NULL ,
nome VARCHAR(50) NOT NULL,
cognome VARCHAR(50) NOT NULL,
FOREIGN KEY (id_convegno) REFERENCES Convegni(id))";

execute_query($conn,$query);



