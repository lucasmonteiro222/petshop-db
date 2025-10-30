<?php
session_start();
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';

if (!isset($_SESSION['usuario_id'])) {
  header("Location: $base_url/views/login.php");
  exit();
}

$usuario = $_SESSION['usuario_nome'];
$nivel_acesso = $_SESSION['nivel_acesso'];

date_default_timezone_set('America/Sao_Paulo');
$dataAtual = date('Y-m-d');
$dataFormatada = date('d/m/Y');


$sql = "
  SELECT 
    a.data_hora, 
    a.servico, 
    c.nome AS cliente, 
    c.pet
  FROM agendamentos a
  INNER JOIN clientes c ON a.id_cliente = c.id_cliente
  WHERE DATE(a.data_hora) = ?
  ORDER BY a.data_hora ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dataAtual);
$stmt->execute();
$result = $stmt->get_result();
$agendamentos = [];

while ($row = $result->fetch_assoc()) {
  $agendamentos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Petzen</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/dashboard.css">
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
    <h1 class="dashboard-title">Dashboard</h1>

    <div class="dashboard-container">
      
      <div class="dashboard-card">
        <h3>Ações rápidas</h3>
        <div class="dashboard-actions">
          <button onclick="window.location.href='<?= $base_url ?>/views/agendamento.php'">
            <i class="bi bi-calendar-plus"></i> Novo Agendamento
          </button>

          <button onclick="window.location.href='<?= $base_url ?>/views/cadastrar_clientes.php'">
            <i class="bi bi-person-plus"></i> Cadastrar Cliente
          </button>
        </div>
      </div>

      
      <div class="dashboard-card">
        <h3>Agenda do dia (<?= $dataFormatada ?>)</h3>

        <?php if (count($agendamentos) > 0): ?>
          <ul class="agenda-dia">
            <?php foreach ($agendamentos as $ag): ?>
              <li>
                <i class="bi bi-clock"></i>
                <?= date('H:i', strtotime($ag['data_hora'])) ?> - 
                <?= htmlspecialchars($ag['cliente']) ?> 
                (<?= htmlspecialchars($ag['pet']) ?> - <?= htmlspecialchars($ag['servico']) ?>)
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p style="color:#777; margin-top:10px;">Nenhum agendamento para hoje.</p>
        <?php endif; ?>

        <p class="agenda-vermais">
          <a href="<?= $base_url ?>/views/agenda.php" style="text-decoration:none; color:#007b7b;">
            ver agenda completa...
          </a>
        </p>
      </div>
    </div>
  </main>
</body>
</html>
