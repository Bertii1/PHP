<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <title>Device Table</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    table {
      border-collapse: collapse;
      width: 80%;
      max-width: 900px;
      background-color: rgba(255, 255, 255, 0.1);
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(8px);
      border-left: 5px, solid, #637CA9;
      border-right: 5px, solid, #637CA9;
      border-bottom: 5px, solid, #637CA9;
      border-radius: 12px;

    }

    th,
    td {
      padding: 14px 18px;
      text-align: left;
    }

    th {
      background-color: rgba(0, 0, 0, 0.4);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.08);
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.2);
      transition: 0.3s ease;
    }

    caption {
      caption-side: top;
      font-size: 1.8em;
      font-weight: 600;
      margin-bottom: 15px;
      color: #fff;
    }
  </style>
</head>

<body>
  <table id="table">
    <caption>Elenco Dispositivi</caption>
    <?php
    $filename = "device.csv"; 

    if (isset($_POST['tipo'])) {
      $tipo = $_POST['tipo'];
      switch($tipo){
        case 'dispositivo':
          $dispositivo = $_POST['dispositivo'];
          SearchTable($dispositivo,1);
          break;
        case 'risoluzione':
          $risoluzione = $_POST['risoluzione'];
          SearchTable($risoluzione,2);
          break;
        case 'OS':
          $sistema_operativo = $_POST['OS'];
          SearchTable($sistema_operativo,3);
          break;
      }
      
      
    }

    function SearchTable($value,$column){
      global $filename;
      $file = fopen("../".$filename, "r");
      $row = 0;
      while (($line = fgetcsv($file)) !== false) {
        if ($row === 0) {
          echo "<tr>";
          foreach ($line as $cell) {
            echo "<th>" . htmlspecialchars($cell) . "</th>";
          }
          echo "</tr>";
        } else {
          // Filter rows: only show if the specified column matches the search value
          if (isset($line[$column]) && stripos($line[$column], $value) !== false) {
            echo "<tr>";
            foreach ($line as $cell) {
              echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
          }
        }
        $row++;
      }
      fclose($file);
    }
    ?>
  </table>
</body>

</html>