<html>
<head>
  <title>File in Remoto</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    
    .container {
      background: white;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      max-width: 500px;
      width: 100%;
    }
    
    h1 {
      color: #333;
      margin-bottom: 30px;
      text-align: center;
      font-size: 28px;
    }
    
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    label {
      color: #555;
      font-weight: 600;
      font-size: 16px;
    }
    
    select {
      padding: 12px 15px;
      font-size: 16px;
      border: 2px solid #ddd;
      border-radius: 8px;
      background: white;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    select:hover {
      border-color: #667eea;
    }
    
    select:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
  </style>
</head>
<body>
<div class="container">
  <h1>📁 Seleziona Estensione File</h1>
  <form action="files.php" method="post">
    <label for="filetype">Tipo di file:</label>
    <select name="estenzione" id="filetype" onchange="this.form.submit()">
      <option value="">Scegli Un estenzione</option>
    <?php
      $dir = "./progetti";
      if (is_dir($dir)) {
          if ($dh = opendir($dir)) {
            $estensioni = [];
              while (($file = readdir($dh)) !== false) {
                  if(filetype($dir . '/' . $file) == "file") {
                    if($file != "." && $file != "..") {
                      $estensione = pathinfo($file, PATHINFO_EXTENSION);
                      if(!in_array($estensione, $estensioni)) {
                        $estensioni[] = $estensione;
                        echo "\n\t\t<option value='$estensione'>.$estensione</option>";
                      }
                      
                    }
                  }
              }
              echo("\n");
              closedir($dh);
          }
      }
    ?>
    </select>
  </form>
</div>
</body>
</html>
