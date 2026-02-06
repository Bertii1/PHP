<html>
  <head>

  </head>
  <body>
    <form action="files.php" method="GET">
    <select name="estensione" onchange="this.form.submit()">
      <option>--Scegli una Estensione--</option>
      <?php
      $dir = "./progetti";
      if(is_dir($dir)){
        $handle = opendir($dir);
        $estensioni = [];
        while (($files = readdir($handle))!== false){
          $estensione = pathinfo($files,PATHINFO_EXTENSION);
          if(!in_array($estensione,$estensioni)){
            echo("<option value=".$estensione.">.".$estensione."</option>");
            $estensioni[] = $estensione;
          }
        }
      }else{
        echo("la cartella:".$dir."non esiste");
      }


    ?>
    </select>
    </form>
    
  </body>
</html>