<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrazione</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      background-color: #ffffff;
      color: #000000;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    form {
      width: 100%;
      max-width: 400px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      padding: 40px;
      border: 1px solid #000000;
      background-color: #ffffff;
    }

    h1 {
      text-align: center;
      font-size: 28px;
      font-weight: 300;
      margin-bottom: 20px;
      letter-spacing: 1px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    select {
      padding: 12px 16px;
      border: 1px solid #000000;
      background-color: #ffffff;
      color: #000000;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus,
    select:focus {
      outline: none;
      border: 2px solid #000000;
      padding: 11px 15px;
    }

    input[type="text"]::placeholder,
    input[type="password"]::placeholder,
    input[type="email"]::placeholder {
      color: #999999;
    }

    input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      margin-right: 8px;
      accent-color: #000000;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
    }

    button {
      padding: 12px 24px;
      border: 1px solid #000000;
      background-color: #000000;
      color: #ffffff;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
    }

    button:hover {
      background-color: #ffffff;
      color: #000000;
      border: 1px solid #000000;
    }

    button:active {
      transform: scale(0.98);
    }

    .form-footer {
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #000000;
      font-size: 14px;
    }

    .form-footer a {
      color: #000000;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .form-footer a:hover {
      text-decoration: underline;
      opacity: 0.7;
    }
  </style>
</head>

<body>
  <form method="POST" action="">
    <h1>Registrazione</h1>
    <input type="text" name="utente" id="utente" placeholder="Nome Utente" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <input type="password" name="password2" id="conferma_password" placeholder="Conferma Password" required>
    <button type="submit">Registrati</button>
    <div class="form-footer">
      Hai già un account? <a href="index.php">Accedi qui</a>
    </div>
  </form>
</body>

</html>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST["utente"]) && isset($_POST["password"]) && isset($_POST["password2"])){
        if($_POST["password"] !== $_POST["password2"]){
            http_response_code(400);
            print("<h1 style='color: red;'>Le password non coincidono</h1>");
        }else{
          $file = file_get_contents("../data/utenti.json");
          $json = json_decode($file);
          $nuovo_utente = [
            "id" => $json[(count($json)-1)],
            "utente" => $_POST["utente"],
            "password" => $_POST["password"],
            "tipo" => "user"
          ];
          $json[] = $nuovo_utente;
          file_put_contents("../data/utenti.json",json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
          setcookie("logged", json_encode(["utente"=>$_POST["utente"],"password"=>$_POST["password"]]), time() + (86400 * 30), "/", "", false, true);
          header("Location: index.php"); // Redirect dopo registrazione
          exit();
        }
    }   
  }
?>
