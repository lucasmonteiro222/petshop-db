<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id_agendamento']);
  $status = $_POST['status'];

  $sql = "UPDATE agendamentos SET status = ? WHERE id_agendamento = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $status, $id);
  $stmt->execute();

  header("Location: ../views/agenda.php");
  exit();
}
?>
