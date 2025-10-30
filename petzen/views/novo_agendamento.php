<?php require_once __DIR__ . '/../includes/config.php'; 
require_once '../includes/auth.php';?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Novo Agendamento</title>
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/agenda.css">
</head>
<body>
  <main class="form-container">
    <h1>Novo Agendamento</h1>
    <form action="../controllers/SalvarAgendamentoController.php" method="POST">
      <label>Cliente</label>
      <input type="text" name="cliente_nome" required>

      <label>Pet</label>
      <input type="text" name="pet_nome" required>

      <label>Serviço</label>
      <input type="text" name="servico" required>

      <label>Data</label>
      <input type="date" name="data" required>

      <label>Hora</label>
      <input type="time" name="hora" required>

      <button type="submit"><i class="bi bi-save"></i> Salvar</button>
      <a href="agenda.php" class="cancelar">Cancelar</a>
    </form>
  </main>
</body>
</html>
