<html>

<head>
  <title>Ricerca per Proprietà</title>
</head>
<style>
  select {
    margin: 10px;
  }
  select[hidden]{
    display: none;
  }
</style>

<body>
  <form id="form" action="search.php" method="POST">
    <select id="tipo" name="tipo" required>
      <option value="">Tipo</option>
      <option value="dispositivo">Dispositivo</option>
      <option value="risoluzione">risoluzione</option>
      <option value="sistema">sistema</option>
    </select>

    <select id="dispositivo" name="dispositivo" hidden>
      <option value="">Dispositivo</option>
      <option value="mobile">mobile</option>
      <option value="desktop">desktop</option>
      <option value="tablet">tablet</option>
      <option value="laptop">laptop</option>
    </select>

    <select id="risoluzione" name="risoluzione" hidden>
      <option value="">Risoluzione</option>
      <option value="3840x2160">3840x2160</option>
      <option value="2560x1440">2560x1440</option>
      <option value="1280x720">1280x720</option>
      <option value="640x480">640x480</option>
    </select>

    <select id="sistema_operativo" name="OS" hidden>
      <option value="">Sistema Operativo</option>
      <option value="macos">macOS</option>
      <option value="ios">iOS</option>
      <option value="linux">Linux</option>
      <option value="windows">Windows</option>
    </select>
    <input type="submit" value="Ricerca">
  </form>
</body>
<script>
  document.getElementById("tipo").addEventListener('change', function(e) {
    switch (e.target.value) {
      case 'dispositivo':
        document.getElementById("dispositivo").hidden = false;
        document.getElementById("dispositivo").required = true;
        document.getElementById("risoluzione").hidden = true;
        document.getElementById("sistema_operativo").hidden = true;
        break;
      case 'risoluzione':
        document.getElementById("dispositivo").hidden = true;
        document.getElementById("dispositivo").required = false;
        document.getElementById("risoluzione").hidden = false;
        document.getElementById("sistema_operativo").hidden = true;
        break;
      case 'sistema':
        document.getElementById("dispositivo").hidden = true;
        document.getElementById("dispositivo").required = false;
        document.getElementById("risoluzione").hidden = true;
        document.getElementById("sistema_operativo").hidden = false;
        break;
      default:
        document.getElementById("dispositivo").hidden = true;
        document.getElementById("dispositivo").required = false;
        document.getElementById("risoluzione").hidden = true;
        document.getElementById("sistema_operativo").hidden = true;
        break;
    }
  })
</script>

</html>