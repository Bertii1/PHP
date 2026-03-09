<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrazione</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="auth-card">
  <?php
    if(isset($_POST['email'])){
      /*genero un array associativo partendo dal file json*/
      $file = file_get_contents("Users.json");
      $json = json_decode($file,true);

      /*prendo i parametri della richiesta POST*/
      $email = $_POST['email'];
      $password = $_POST['password'];

      /*
        ciclo tutto l array associativo finche non trovo l'email 
        una volta trovata l'email vado a controllare se la password è giusta
        se si il Login è avvenuto con successo
      */
      for($i = 0; $i < count($json["utenti"]); $i++){
        if($json["utenti"][$i]["email"] === $email){
          echo("<div class='small'>L'utente esiste già</div>");
        }
      }
    }else{
      echo ("<div class='small'>Richiesta POST non ricevuta</div>");
    }
  
  
  ?>
  </div>
  
</body>
</html>