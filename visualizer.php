<html>
  <head>
    <title>CSV Table</title>
  </head>
<body>
  <table>
    <?php
    $file = fopen("device.csv", "r");
    $row = 0;
    while (($line = fgetcsv($file)) !== false) {
      if ($row > 0) {
        print ("<tr><td>" . $line[0] . "</td><td>" . $line[1] . "</td><td>" . $line[2] . "</td><td>" . $line[3] . "</td></td>");
      } else {
        print ("<tr><th>" . $line[0] . "</th><th>" . $line[1] . "</th><th>" . $line[2] . "</th><th>" . $line[3] . "</th></tr>");
      }
      $row++;
    }
    fclose($file);
    ?>
  </table>
</body>
<style>
  td{
    border:2px,solid,black;
  }
</style>
</html>