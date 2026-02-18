<?php
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/auth.php";

require_admin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  global $conn;

  $json = file_get_contents('php://input');
  $json = json_decode($json, true);

  $nome_convegno = $conn->real_escape_string($json["nome_convegno"]);
  $numero_partecipanti = intval($json["numero_partecipanti"]);

  $query = "INSERT INTO Convegni (`nome_convegno`,`numero_partecipanti`) VALUES (
        '$nome_convegno', $numero_partecipanti)";

  execute_query($conn, $query);

  $res = execute_query($conn, "SELECT id FROM Convegni WHERE nome_convegno='$nome_convegno'");
  $id_convegno = null;
  if ($res) {
    foreach ($res as $row) {
      $id_convegno = intval($row["id"]);
    }
  }

  if ($id_convegno) {
    $partecipanti = $json["partecipanti"];
    foreach ($partecipanti as $partecipante) {
      $nome = $conn->real_escape_string($partecipante["nome"]);
      $cognome = $conn->real_escape_string($partecipante["cognome"]);
      $query = "INSERT INTO Partecipanti (`id_convegno`,`nome`,`cognome`) VALUES ($id_convegno, '$nome', '$cognome')";
      execute_query($conn, $query);
    }
  }

  echo json_encode(["success" => true]);
  exit;
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prenotazione Convegno</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f5f5f5;
      color: #1a1a1a;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      font-size: 16px;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 24px;
      font-weight: 600;
      color: #1a1a1a;
    }

    .form-group {
      margin-bottom: 24px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #333;
      font-size: 14px;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #d0d0d0;
      border-radius: 4px;
      font-size: 16px;
      font-family: inherit;
      background-color: #fafafa;
      color: #1a1a1a;
      transition: border-color 0.2s, background-color 0.2s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus {
      outline: none;
      border-color: #1a1a1a;
      background-color: #ffffff;
    }

    #lista_partecipanti {
      margin: 30px 0;
      padding: 20px;
      background-color: #fafafa;
      border-radius: 4px;
      min-height: 60px;
    }

    .partecipante-group {
      margin-bottom: 16px;
      padding-bottom: 16px;
      border-bottom: 1px solid #e0e0e0;
    }

    .partecipante-group:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .partecipante-group label {
      margin-bottom: 6px;
      color: #666;
      font-size: 13px;
    }

    .button-container {
      display: flex;
      gap: 12px;
      margin-top: 30px;
    }

    button {
      flex: 1;
      padding: 12px 24px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      font-family: inherit;
    }

    #salva_button {
      background-color: #1a1a1a;
      color: #ffffff;
    }

    #salva_button:hover:not(:disabled) {
      background-color: #333;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    #salva_button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
      color: #999;
    }

    button:active:not(:disabled) {
      transform: scale(0.98);
    }

    #table_partecipanti {
      color: #ffffff;
    }

    #table_partecipanti thead th {
      padding: 16px 12px;
      text-align: left;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Prenotazione Convegno</h1>

    <div class="form-group">
      <label for="nome_convegno">Nome Convegno</label>
      <input type="text" id="nome_convegno" placeholder="Inserisci il nome del convegno">
    </div>

    <div class="form-group">
      <label for="numero_partecipanti">Numero Partecipanti</label>
      <input type="number" id="numero_partecipanti" placeholder="1" min="1" onchange="load_lista()">
    </div>

    <div id="lista_partecipanti"></div>

    <div class="button-container">
      <button id="salva_button" onclick="salva()" disabled>Salva</button>
    </div>
  </div>

  <script>
    function load_lista() {
      const numero_partecipanti = document.getElementById("numero_partecipanti").value
      document.getElementById("numero_partecipanti").disabled = true
      const div_partecipanti = document.getElementById("lista_partecipanti")
      for (let i = 0; i < numero_partecipanti; i++) {
        div_partecipanti.appendChild(buildPartecipanteCard(i))
      }

      document.getElementById("salva_button").disabled = false

      function buildPartecipanteCard(i) {
        const div_partecipante = document.createElement("div")
        const label_nome = document.createElement("label")
        label_nome.setAttribute("for", "name" + i)
        label_nome.textContent = "Nome:"
        div_partecipante.appendChild(label_nome)

        const nome_input = document.createElement("input")
        nome_input.type = "text"
        nome_input.id = "name" + i
        nome_input.placeholder = "nome"
        nome_input.required = true
        div_partecipante.appendChild(nome_input)

        const label_cognome = document.createElement("label")
        label_cognome.setAttribute("for", "surname" + i)
        label_cognome.textContent = "Cognome:"
        div_partecipante.appendChild(label_cognome)

        const cognome_input = document.createElement("input")
        cognome_input.type = "text"
        cognome_input.id = "surname" + i
        cognome_input.placeholder = "cognome"
        cognome_input.required = true
        div_partecipante.appendChild(cognome_input)
        return div_partecipante
      }

    }

    function salva() {
      var nome_convegno = document.getElementById("nome_convegno").value
      var numero_partecipanti = document.getElementById("numero_partecipanti").value
      var partecipanti = document.getElementById("lista_partecipanti").childNodes
      var convegno_data = {
        "nome_convegno": nome_convegno,
        "numero_partecipanti": numero_partecipanti,
        "partecipanti": []
      }

      partecipanti.forEach(partecipante => {
        var pobj = {
          "nome": null,
          "cognome": null,
        }
        let c = 0
        partecipante.childNodes.forEach(elmnt => {
          if (elmnt.tagName === "INPUT") {
            if (c === 0) {
              pobj.nome = elmnt.value
            } else {
              pobj.cognome = elmnt.value
            }
            c++
          }
        })
        convegno_data.partecipanti.push(pobj)
      })
      console.log(convegno_data)
      SendData()

      function SendData() {
        fetch("prenota.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(convegno_data)
        })
      }
    }
  </script>
</body>

</html>