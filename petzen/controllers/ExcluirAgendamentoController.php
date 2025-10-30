<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = intval($_POST['id_agendamento']);
  $sql = "DELETE FROM agendamentos WHERE id_agendamento = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header("Location: ../views/agenda.php");
  exit();
}
?>
