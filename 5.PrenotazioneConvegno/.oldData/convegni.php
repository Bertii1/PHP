<?php

$server = "localhost";
$user = "GestioneConvegni_app";
$db_password = "ciaodario";
$dbname = "GestioneConvegni";

function execute_query($connection, $SQLquery)
{
  if ($connection->query($SQLquery) === true) {
    echo "query eseguita\n";
  } else {
    echo "errore nell esecuzione della query: " . $connection->error . "\n";
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
numero_partecipanti INT(6))";

execute_query($conn,$query);

$query = "CREATE TABLE IF NOT EXISTS Partecipanti(
id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
id_convegno INT(6) NOT NULL ,
nome VARCHAR(50) NOT NULL,
cognome VARCHAR(50) NOT NULL,
FOREIGN KEY (id_convegno) REFERENCES Convegni(id))";

execute_query($conn,$query);

$files = scandir("./convegni");
$id = 1;
foreach( $files as $file){
 if(strlen($file) > 2){
  $file = "./convegni/".$file;
  print($file);
    $json = file_get_contents($file);
    $json = json_decode($json,true);

    $nome_convegno = $json["nome_convegno"];
    $numero_partecipanti = $json["numero_partecipanti"];
    $query="INSERT INTO Convegni(nome_convegno,numero_partecipanti) VALUES ('".$nome_convegno."','".$numero_partecipanti."');";

    execute_query($conn,$query);

    for($i = 0;$i < count($json["partecipanti"]);$i++){
      $nome = $json["partecipanti"][$i]["nome"];
      $cognome = $json["partecipanti"][$i]["cognome"];
    $query = "INSERT INTO Partecipanti(id_convegno,nome, cognome) VALUES ('" 
    . $id . "', '" 
    . $nome . "', '" 
    . $cognome . "');";

    execute_query($conn,$query);
    }
    $id++;
    
  
 }
}