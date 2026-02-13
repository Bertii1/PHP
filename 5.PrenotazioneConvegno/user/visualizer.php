<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista Convegni</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #ffffff;
      color: #000000;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      font-size: 16px;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 600px;
      padding: 40px;
      text-align: center;
    }

    h1 {
      margin-bottom: 40px;
      font-size: 28px;
      font-weight: 300;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    #select_convegno {
      width: 100%;
      padding: 14px 16px;
      margin-bottom: 40px;
      border: 1px solid #000000;
      background-color: #ffffff;
      color: #000000;
      font-size: 16px;
      font-family: inherit;
      cursor: pointer;
      transition: all 0.2s;
    }

    #select_convegno:hover,
    #select_convegno:focus {
      outline: none;
      box-shadow: 0 0 0 2px #000000;
      background-color: #f9f9f9;
    }

    #table_partecipanti {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    #table_partecipanti tr {
      border-bottom: 1px solid #000000;
    }

    #table_partecipanti tr:last-child {
      border-bottom: none;
    }

    #table_partecipanti td {
      padding: 16px 12px;
      text-align: left;
      font-weight: 400;
      border: 1px solid #000000;
    }

    #table_partecipanti td:first-child {
      font-weight: 500;
    }

    #table_partecipanti thead {
      background-color: #000000;
      color: #ffffff;
    }

    #table_partecipanti thead th {
      padding: 16px 12px;
      text-align: left;
      font-weight: 600;
      border: 1px solid #000000;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Convegni</h1>
    <select id="select_convegno" onchange="CaricaPartecipanti()">
      <option value="">Seleziona un convegno</option>
      <?php
      session_start();
      if ($_SESSION["tipo"] !== "")
        $hostname = "127.0.0.1";
      $username = "GestioneConvegni_app";
      $password = "ciaodario";
      $db_name = "GestioneConvegni";

      $conn = new mysqli($hostname, $username, $password, $db_name);

      //controlla se la connessione al DataBase è andata a buon fine
      if ($conn->connect_error) {
        die("errore di connessione: " . $conn->connect_error . "\n");
      } else {
        echo "connected to DB\n";
      }

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

      $query = "
      SELECT * FROM Convegni v
      ";

      $result = execute_query($conn, $query);
      if ($result != false) {
        foreach ($result as $row) {
          echo ("<option value=" . $row["id"] . ">" . $row["nome_convegno"] . "</option>");
        }
      }




      ?>
    </select>
    <table id="table_partecipanti">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Cognome</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET["file_convegno"]) && !empty($_GET["file_convegno"])) {
          session_start();
          if ($_SESSION == "admin" || $_SESSION == "user") {
            $filename = $_GET["file_convegno"];
            $filepath = "./convegni/" . basename($filename);

            if (file_exists($filepath)) {
              $json = file_get_contents($filepath);
              $json = json_decode($json, true);

              if ($json && isset($json["partecipanti"])) {
                for ($i = 0; $i < count($json["partecipanti"]); $i++) {
                  $partecipante = $json["partecipanti"][$i];
                  echo "<tr><td>" . htmlspecialchars($partecipante["nome"]) . "</td><td>" . htmlspecialchars($partecipante["cognome"]) . "</td></tr>\n";
                }
              }
            }
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <script>
    function CaricaPartecipanti() {
      let nomeConvegno = document.getElementById("select_convegno").value
      window.location = window.location + "?" + new URLSearchParams({ "file_convegno": nomeConvegno }).toString();
    }
  </script>
</body>

</html>