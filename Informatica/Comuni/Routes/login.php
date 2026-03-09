<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login AJAX/PHP/JSON</title>
</head>
<body>
    <h2>Pagina di Login</h2>

    <form id="loginForm">
        <label for="username">Nome Utente:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Accedi</button>
    </form>

    <!-- Qui mostreremo il messaggio di stato -->
    <p id="statusMessage"></p>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Impedisce il submit standard del form

            const formData = new FormData(this);
            const statusMessage = document.getElementById('statusMessage');

            fetch('authenticate.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Analizza la risposta JSON
            .then(data => {
                if (data.success) {
                    statusMessage.style.color = 'green';
                    statusMessage.textContent = 'Accesso riuscito! Benvenuto, ' + data.username;
                    // Qui puoi reindirizzare l'utente: window.location.href = 'dashboard.html';
                } else {
                    statusMessage.style.color = 'red';
                    statusMessage.textContent = 'Errore di login: ' + data.message;
                }
            })
            .catch(error => {
                console.error('Errore durante la richiesta:', error);
                statusMessage.style.color = 'red';
                statusMessage.textContent = 'Si è verificato un errore di rete.';
            });
        });
    </script>
</body>
</html>


***********************************************************************************************************


<?php
header('Content-Type: application/json'); // Dichiara che la risposta è JSON

// 1. Controlla se i dati POST sono arrivati
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo json_encode(['success' => false, 'message' => 'Dati incompleti inviati.']);
    exit;
}

$inputUser = $_POST['username'];
$inputPass = $_POST['password'];

// 2. Leggi il contenuto del file JSON
$json_data = file_get_contents('users.json');

// 3. Decodifica il JSON in un array associativo PHP
$users = json_decode($json_data, true);

$authenticated = false;
$foundUser = null;

// 4. Cerca l'utente e valida la password
foreach ($users as $user) {
    if ($user['username'] === $inputUser && $user['password'] === $inputPass) {
        $authenticated = true;
        $foundUser = $user['username'];
        break; // Trovato l'utente, interrompi il ciclo
    }
}

// 5. Restituisci la risposta in formato JSON al JavaScript
if ($authenticated) {
    echo json_encode(['success' => true, 'message' => 'Accesso consentito', 'username' => $foundUser]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nome utente o password non validi.']);
}
?>



Ecco una sintesi di come l'AJAX viene utilizzato specificamente in quell'esempio:
Evento AJAX Scatenato: Quando l'utente clicca sul pulsante "Accedi" nel file login.html, il JavaScript intercetta l'evento submit del form.
Richiesta Asincrona (fetch): Invece di far inviare al browser il modulo in modo tradizionale (che ricaricherebbe la pagina), 
la funzione fetch('authenticate.php', ...) invia i dati in background.
PHP Elabora e Restituisce JSON: Lo script PHP (authenticate.php) legge il JSON degli utenti, verifica le credenziali e 
restituisce una risposta codificata in JSON (es. {"success": true, ...}).
Gestione della Risposta: Il JavaScript riceve questa risposta JSON (.then(response => response.json())) e, in base al valore di 
success (vero o falso), aggiorna solo la sezione statusMessage della pagina HTML (modificando il testo e il colore), senza ricaricare l'intera pagina.


<p>DIGITARE REGIONE:</p>
<p>Suggestions: <span id="regioneT"></span></p>

<form>
REGIONE: <input type="text" onkeyup="cercaRegione(this.value)">
</form>

<script>
function cercaRegione(str) {
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      document.getElementById("regioneT").innerHTML = this.responseText;
    }
  xmlhttp.open("GET", "gethint.php?q=" + str);
  xmlhttp.send();
  }
}
</script>