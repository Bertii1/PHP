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
    LoadTable(false);

    if (isset($_POST['dispositivo'])) {
      $dispositivo = $_POST['dispositivo'];
      $risoluzione = $_POST['risoluzione'];
      $sistema_operativo = $_POST['sistema_operativo'];
      $matricola = 0;
      $lines = file($filename);
      if (is_string($lines[count($lines) - 1][0])){
        $matricola = 1;
      }else{
        $matricola = $lines[count($lines) - 1][0] + 1;
      }
      $data = array($matricola, $dispositivo, $risoluzione, $sistema_operativo);
      appendCSV($data);
      LoadTable(true);
    }

    function appendCSV($data){
      global $filename;
    
      $fp = fopen($filename, 'a');
      fputcsv($fp, $data);
      fclose($fp);
    }

    function EmptyTable($caller){
      echo '<script>document.getElementById("table").innerHTML = "";
      console.log("Wipe Table from '.$caller.'");</script>';
    }

    function LoadTable($empty){
      if($empty){
        EmptyTable("Load Table");
      }
      $file = fopen("device.csv", "r");

      $row = 0;
      while (($line = fgetcsv($file)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
          if ($row === 0)
            echo "<th>" . htmlspecialchars($cell) . "</th>";
          else
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
        $row++;
      }
      fclose($file);
    }

    ?>
  </table>
</body>

</html>