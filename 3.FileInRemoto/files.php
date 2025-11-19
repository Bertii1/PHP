<html>
<head>
  <title>Files</title>
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
      padding: 40px 20px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    h1 {
      color: #333;
      margin-bottom: 30px;
      text-align: center;
      font-size: 28px;
    }
    
    .table-wrapper {
      overflow-x: auto;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    table {
      width: 90%;
      border-collapse: collapse;
      background: white;
    }
    
    tr {
      border-bottom: 1px solid #eee;
      transition: all 0.2s ease;
    }
    
    tr:last-child {
      border-bottom: none;
    }
    
    tr:hover {
      background-color: #f8f9ff;
      transform: translateX(5px);
    }
    
    td {
      padding: 18px 15px;
      vertical-align: middle;
    }
    
    td:first-child {
      width: 50px;
      text-align: center;
    }
    
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #999;
      font-size: 18px;
    }
    
    .empty-state::before {
      content: "📭";
      display: block;
      font-size: 60px;
      margin-bottom: 15px;
    }
    
    a {
      color: #667eea;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s ease;
    }
    
    a:hover {
      color: #764ba2;
      text-decoration: underline;
    }
    
    .back-btn {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 20px;
      background: #667eea;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    
    .back-btn:hover {
      background: #764ba2;
      text-decoration: none;
    }
  </style>
</head>
<body>
<div class="container">
  <a href="index.php" class="back-btn">← Indietro</a>
  <h1>📄 Elenco File</h1>
  
  <div class="table-wrapper">
    <table> 
      <?php
      $dir = "./progetti";
      $fileCount = 0; 
      if(isset($_POST['estenzione'])) {
        $ext = $_POST['estenzione'];
        if ($dh = opendir($dir)) {
              while (($file = readdir($dh)) !== false) {
                  if(filetype($dir . '/' . $file) == "file") {
                    if($file != "." && $file != "..") {
                      $estensione = pathinfo($file, PATHINFO_EXTENSION);
                      if($estensione == $ext) { 
                        echo "<tr><td><img src='./img/$estensione.svg' width='20' height='20'></td><td>
                        <a href='./progetti/$file'>$file</a></td></tr>";
                        $fileCount++;
                      }
                    }
                  }
              }
              closedir($dh);
          }
      }

      if($fileCount == 0) {
        echo "<tr><td colspan='2'><div class='empty-state'>Nessun file trovato</div></td></tr>";
      }

      ?>
    </table>
  </div>
</div>
</body>
</html>
