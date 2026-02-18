<?php
require_once __DIR__ . "/../includes/auth.php";
require_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
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

    .menu-container {
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

    .menu-items {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .menu-link {
      display: block;
      padding: 16px 24px;
      border: 1px solid #000000;
      background-color: #000000;
      color: #ffffff;
      text-decoration: none;
      text-align: center;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
    }

    .menu-link:hover {
      background-color: #ffffff;
      color: #000000;
      border: 1px solid #000000;
    }

    .menu-link:active {
      transform: scale(0.98);
    }

    .menu-footer {
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #000000;
      font-size: 14px;
    }

    .menu-footer a {
      color: #000000;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .menu-footer a:hover {
      text-decoration: underline;
      opacity: 0.7;
    }
  </style>
</head>

<body>
  <div class="menu-container">
    <h1>Menu</h1>
    <div class="menu-items">
      <a href="../user/visualizer.php" class="menu-link">Visualizzatore</a>
      <a href="prenota.php" class="menu-link">Nuovo Convegno</a>
      <a href="../auth/registrazione.php" class="menu-link">Registrazione</a>
    </div>
    <div class="menu-footer">
      <a href="../auth/logout.php">Logout</a>
    </div>
  </div>
</body>

</html>