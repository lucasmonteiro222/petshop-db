<?php
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['usuario_id'])) {
    header("Location: $base_url/views/login.php");
    exit();
}

$usuario = $_SESSION['usuario_nome'];


$query = "SELECT id_cliente, nome, pet FROM clientes ORDER BY nome ASC";
$result = $conn->query($query);
$clientes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendamento - Petzen</title>

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
          <li><a href="<?= $base_url ?>/views/agenda.php"><i class="bi bi-calendar3"></i> Agenda</a></li>
          <li><a href="<?= $base_url ?>/views/cadastrar_clientes.php"><i class="bi bi-people"></i> Clientes</a></li>
          <li><a href="<?= $base_url ?>/views/agendamento.php" class="active"><i class="bi bi-calendar-plus"></i> Agendamento</a></li>
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
    <div class="page-header">
  <h1>Agendamento de Serviços</h1>
</div>


    <div class="agendamento-container">
      <form action="<?= $base_url ?>/controllers/SalvarAgendamentoController.php" method="POST" class="form-agendamento">
        <label for="cliente">Cliente:</label>
        <select name="id_cliente" id="cliente" required>
          <option value="">Selecione um cliente</option>
          <?php foreach ($clientes as $c): ?>
            <option value="<?= $c['id_cliente'] ?>">
              <?= htmlspecialchars($c['nome']) ?> — <?= htmlspecialchars($c['pet']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label for="servico">Tipo de Serviço:</label>
        <select name="servico" id="servico" required>
          <option value="Banho">Banho</option>
          <option value="Tosa">Tosa</option>
          <option value="Banho e Tosa">Banho e Tosa</option>
        </select>

        <div class="date-time-group">
          <div>
            <label for="data">Data:</label>
            <input type="date" name="data" id="data" required>
          </div>
          <div>
            <label for="hora">Hora:</label>
            <input type="time" name="hora" id="hora" required>
          </div>
        </div>

        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" id="observacoes" rows="3" placeholder="Ex: cliente prefere tosa baixa..."></textarea>

        <div class="btn-group">
          <button type="submit" class="btn-salvar">
            <i class="bi bi-check-circle"></i> Salvar Agendamento
          </button>
          <a href="<?= $base_url ?>/views/agenda.php" class="btn-voltar">
            <i class="bi bi-arrow-left-circle"></i> Voltar
          </a>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
