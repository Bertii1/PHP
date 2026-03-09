<?php
session_start();

function require_login()
{
  if (!isset($_SESSION["tipo_utente"]) || $_SESSION["tipo_utente"] === "") {
    header("Location: ../auth/login.php");
    exit;
  }
}

function require_admin()
{
  if (!isset($_SESSION["tipo_utente"]) || $_SESSION["tipo_utente"] !== "admin") {
    http_response_code(403);
    echo "<h1 style='color: red;'>Non puoi accedere a questa pagina</h1>";
    header("Refresh: 2; URL=../auth/login.php");
    exit;
  }
}

function set_remeber_me($username, $password)
{
  if (!isset($_COOKIE["remember_me_hash"]) && $_COOKIE["remember_me_hash"] !== "") {
    $hashed_password = password_hash($password,"sha256");
    setcookie("remember_me_hash", $hashed_password,time()*60*60,);
  }

}
