<?php
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';

if (!isset($_GET['id'])) {
  header("Location: $base_url/views/agenda.php");
  exit();
}

$id_agendamento = intval($_GET['id']);


$sql = "SELECT * FROM agendamentos WHERE id_agendamento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_agendamento);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Agendamento não encontrado.");
}

$agendamento = $result->fetch_assoc();


$sqlClientes = "SELECT id_cliente, nome, pet FROM clientes ORDER BY nome ASC";
$resClientes = $conn->query($sqlClientes);
$clientes = [];
if ($resClientes && $resClientes->num_rows > 0) {
  while ($row = $resClientes->fetch_assoc()) {
    $clientes[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Agendamento - Petzen</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/agendamento.css">
</head>

<body>
 
  <aside>
    <div>
      <div class="logo">
        <img src="<?= $base_url ?>/img/logo.png" alt="Logo Petzen">
        <h1>Petzen</h1>
      </div>
      <nav>
        <ul>
          <li><a href="<?= $base_url ?>/views/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li><a href="<?= $base_url ?>/views/agenda.php" class="active"><i class="bi bi-calendar3"></i> Agenda</a></li>
          <li><a href="<?= $base_url ?>/views/cadastrar_clientes.php"><i class="bi bi-people"></i> Clientes</a></li>
          <li><a href="<?= $base_url ?>/views/relatorios.php"><i class="bi bi-clipboard-data"></i> Relatórios</a></li>
        </ul>
      </nav>
    </div>
    <div class="logout">
      <a href="<?= $base_url ?>/controllers/LogoutController.php">Sair</a>
    </div>
  </aside>

  
  <header>
    <div>SISTEMA DE GESTÃO INTERNA</div>
    <div>Olá, <?= htmlspecialchars($usuario) ?></div>
  </header>

  
  <main>
    <h1>Editar Agendamento</h1>

    <div class="agendamento-container">
      <form action="<?= $base_url ?>/controllers/AtualizarAgendamentoController.php" method="POST" class="form-agendamento">
        <input type="hidden" name="id_agendamento" value="<?= $agendamento['id_agendamento'] ?>">

        <label for="cliente">Cliente:</label>
        <select name="id_cliente" id="cliente" required>
          <?php foreach ($clientes as $c): ?>
            <option value="<?= $c['id_cliente'] ?>" 
              <?= ($c['id_cliente'] == $agendamento['id_cliente']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['nome']) ?> — <?= htmlspecialchars($c['pet']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label for="servico">Tipo de Serviço:</label>
        <select name="servico" id="servico" required>
          <option value="Banho" <?= $agendamento['servico'] == 'Banho' ? 'selected' : '' ?>>Banho</option>
          <option value="Tosa" <?= $agendamento['servico'] == 'Tosa' ? 'selected' : '' ?>>Tosa</option>
          <option value="Banho e Tosa" <?= $agendamento['servico'] == 'Banho e Tosa' ? 'selected' : '' ?>>Banho e Tosa</option>
        </select>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" value="<?= date('Y-m-d', strtotime($agendamento['data_hora'])) ?>" required>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" id="hora" value="<?= date('H:i', strtotime($agendamento['data_hora'])) ?>" required>

        <label for="status">Status:</label>
        <select name="status" id="status">
          <option value="Agendado" <?= $agendamento['status'] == 'Agendado' ? 'selected' : '' ?>>Agendado</option>
          <option value="Concluído" <?= $agendamento['status'] == 'Concluído' ? 'selected' : '' ?>>Concluído</option>
          <option value="Cancelado" <?= $agendamento['status'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
        </select>

        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" id="observacoes" rows="3"><?= htmlspecialchars($agendamento['observacoes']) ?></textarea>

        <button type="submit"><i class="bi bi-save"></i> Salvar Alterações</button>
      </form>
    </div>
  </main>
</body>
</html>
