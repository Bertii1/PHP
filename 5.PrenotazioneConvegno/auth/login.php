<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
    input[type="password"] {
      padding: 12px 16px;
      border: 1px solid #000000;
      background-color: #ffffff;
      color: #000000;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border: 2px solid #000000;
      padding: 11px 15px;
    }

    input[type="text"]::placeholder,
    input[type="password"]::placeholder {
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
    <h1>Accedi</h1>
    <input type="text" name="utente" id="utente" placeholder="Nome Utente" required>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <div class="checkbox-container">
      <input type="checkbox" name="ricordami" id="ricordami">
      <label for="ricordami">Ricordami</label>
    </div>
    <button type="submit">Accedi</button>
    <div class="form-footer">
      Non hai un account? <a href="registrazione.php">Registrati qui</a>
    </div>
  </form>
</body>

</html>

<?php

function execute_query($conn, $query)
{
  $result = $conn->query($query);
  if ($result) {
    echo "query eseguita\n";
    return $result;
  } else {
    echo "errore nell'esecuzione della query: " . $conn->error . "\n";
    return false;
  }
}
function ControllaCredenziali($username, $password)
{
  $db_password = "ciaodario";
  $db_username = "GestioneConvegni_app";
  $db_name = "GestioneConvegni";
  $hostname = "localhost";

  $conn = new mysqli($hostname, $db_username, $db_password, $db_name);

  if ($conn->connect_error) {
    die("errore di connessione: " . $conn->connect_error . "\n");
  } else {
    echo "connected to DB\n";
  }

  $query = "SELECT username, tipo FROM Utenti WHERE username = '" . $username . "' AND password = '" . $password . "'";

  $res = execute_query($conn, $query);

  if ($res != false) {
    foreach ($res as $row) {
      return $row;
    }
  } else {
    return false;
  }

}


session_start();
if ($_COOKIE["loggedIn"] === true) {
  redirectUserByTipo($_COOKIE["tipo"]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["utente"]) && isset($_POST["password"])) {

    $utente = $_POST["utente"];
    $password = $_POST["password"];

    $row = ControllaCredenziali($utente, $password);

    if ($row !== false) {
      $_SESSION["tipo_utente"] = $row["tipo"];
      $_SESSION["utente"] = $row["username"];
      $login_success = true;
      redirectUserByTipo($row["tipo"]);
    }


    if (!$login_success) {
      echo "<script>alert('Credenziali non valide')</script>";
    }

  } else {
    echo "<script>alert('Parametri errati')</script>";
  }
}

function redirectUserByTipo($tipo_Utente)
{
  switch ($tipo_Utente) {
    case "user":
      header("Location: ../user/visualizer.php");
      exit;
    case "admin":
      header("Location: ../admin/menu.php");
      exit;
    default:
      header("Location: ../user/visualizer.php");
      exit;
  }
}




?>