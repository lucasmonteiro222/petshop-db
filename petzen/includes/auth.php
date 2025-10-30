<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../views/login.php");
  exit();
}

$usuario = $_SESSION['usuario_nome'];
$nivelAcesso = $_SESSION['nivel_acesso'];
?>
