<html>
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    h1 {
      color: #fff;
      text-align: center;
      margin-bottom: 25px;
      letter-spacing: 1px;
    }

    form {
      background-color: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.25);
      width: 320px;
      display: flex;
      flex-direction: column;
    }

    input, select {
      padding: 10px 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      outline: none;
      background-color: rgba(255, 255, 255, 0.85);
      font-size: 15px;
      color: #333;
      transition: 0.3s;
    }

    input:focus, select:focus {
      background-color: #fff;
      box-shadow: 0 0 5px #2a5298;
    }

    select {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='12' viewBox='0 0 24 24' width='12' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px;
    }

    button {
      margin-top: 20px;
      padding: 10px;
      border: none;
      border-radius: 8px;
      background-color: #2a5298;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    button:hover {
      background-color: #1e3c72;
      transform: scale(1.05);
    }

    @media (max-width: 400px) {
      form {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <div>
    <h1>Form Login</h1>
    <form id="form" action="visualizer.php" method="post">
      <input type="text" placeholder="Matricola" required>
      <input type="text" placeholder="Dispositivo" required>

      <select required>
        <option value="">Risoluzione</option>
        <option value="3840x2160">3840x2160</option>
        <option value="2560x1440">2560x1440</option>
        <option value="1280x720">1280x720</option>
        <option value="640x480">640x480</option>
      </select>

      <select required>
        <option value="">Sistema Operativo</option>
        <option value="macos">macOS</option>
        <option value="ios">iOS</option>
        <option value="linux">Linux</option>
        <option value="windows">Windows</option>
      </select>

      <button type="submit">Invia</button>
    </form>
  </div>
</body>
</html>
