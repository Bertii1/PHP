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
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(8px);
    }

    th, td {
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
  <table>
    <caption>Elenco Dispositivi</caption>
    <?php
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
    ?>
  </table>
</body>
</html>
