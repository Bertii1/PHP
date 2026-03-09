<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cognome = isset($_POST['cognome']) ? trim($_POST['cognome']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$regione = isset($_POST['regione']) ? trim($_POST['regione']) : '';
$provincia = isset($_POST['provincia']) ? trim($_POST['provincia']) : '';
$comune = isset($_POST['comune']) ? trim($_POST['comune']) : '';

if ($nome === '' || $cognome === '') {
  http_response_code(400);
  echo json_encode(['error' => 'Missing required fields']);
  exit;
}

$dataDir = __DIR__ . '/../data';
if (!is_dir($dataDir)) {
  mkdir($dataDir, 0777, true);
}

$file = $dataDir . '/utenti.json';
$users = [];
if (file_exists($file)) {
  $contents = file_get_contents($file);
  $decoded = json_decode($contents, true);
  if (is_array($decoded)) $users = $decoded;
}

$new = [
  'nome' => $nome,
  'cognome' => $cognome,
  'password' => $password,
  'regione' => $regione,
  'provincia' => $provincia,
  'comune' => $comune,
  'created_at' => date(DATE_ATOM)
];

$users[] = $new;
if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
  http_response_code(500);
  echo json_encode(['error' => 'Unable to write file']);
  exit;
}

echo json_encode(['success' => true, 'user' => $new]);

?>