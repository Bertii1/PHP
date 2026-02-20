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

    .logout-link {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      border: 1px solid #000000;
      background-color: #ffffff;
      color: #000000;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
    }

    .logout-link:hover {
      background-color: #000000;
      color: #ffffff;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Convegni</h1>
    <select id="select_convegno" onchange="CaricaPartecipanti()">
      <option value="">Seleziona un convegno</option>
      <?php
      require_once __DIR__ . "/../includes/auth.php";
      require_once __DIR__ . "/../includes/db.php";
      require_login();

      $query = "SELECT * FROM Convegni";

      $result = execute_query($conn, $query);
      if ($result != false) {
        foreach ($result as $row) {
          echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nome_convegno"]) . '</option>';
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
        if (isset($_GET["id_convegno"]) && !empty($_GET["id_convegno"])) {
          if ($_SESSION["tipo_utente"] == "admin" || $_SESSION["tipo_utente"] == "user") {
            $id_convegno = $_GET["id_convegno"];
            $stmt = $conn->prepare("SELECT * FROM Partecipanti WHERE id_convegno = ?");
            $stmt->bind_param("i", $id_convegno);
            $stmt->execute();
            $res = $stmt->get_result();
            foreach ($res as $row) {
              echo "<tr><td>" . htmlspecialchars($row["nome"]) . "</td><td>" . htmlspecialchars($row["cognome"]) . "</td></tr>";
            }
            $stmt->close();
          }
        }
        ?>
      </tbody>
    </table>
    <a href="../auth/logout.php" class="logout-link">Logout</a>
  </div>
  <script>
    function CaricaPartecipanti() {
      let id_convegno = document.getElementById("select_convegno").value
      window.location = window.location.pathname + "?" + new URLSearchParams({ "id_convegno": id_convegno }).toString();
    }
  </script>
</body>

</html>