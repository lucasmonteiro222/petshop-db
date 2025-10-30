<?php
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';


$periodo = $_GET['periodo'] ?? 'todos';
$where = '';

switch ($periodo) {
  case 'mes':
    $where = "WHERE MONTH(a.data_hora) = MONTH(CURDATE()) AND YEAR(a.data_hora) = YEAR(CURDATE())";
    break;
  case 'semana':
    $where = "WHERE YEARWEEK(a.data_hora, 1) = YEARWEEK(CURDATE(), 1)";
    break;
  case 'ano':
    $where = "WHERE YEAR(a.data_hora) = YEAR(CURDATE())";
    break;
  case 'todos':
  default:
    $where = '';
    break;
}


$query = "
  SELECT a.servico AS servico, COUNT(a.id_agendamento) AS quantidade
  FROM agendamentos a
  $where
  GROUP BY a.servico
  ORDER BY quantidade DESC
";

$result = $conn->query($query);
$relatorios = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $relatorios[] = $row;
  }
}


if (isset($_GET['export']) && $_GET['export'] == 'xls') {
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=relatorio_servicos.xls");

  echo "Serviço\tQuantidade\n";
  foreach ($relatorios as $r) {
    echo "{$r['servico']}\t{$r['quantidade']}\n";
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Relatórios - Petzen</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/relatorios.css">
</head>

<body>
  
  <header>
    <div>SISTEMA DE GESTÃO INTERNA</div>
    <div>Olá, <?= htmlspecialchars($usuario) ?></div>
  </header>

  
  <aside>
    <div class="logo">
      <img src="<?= $base_url ?>/img/logo.png" alt="Logo Petzen">
      <h1>Petzen</h1>
    </div>

    <nav>
      <ul>
        <li><a href="<?= $base_url ?>/views/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="<?= $base_url ?>/views/agenda.php"><i class="bi bi-calendar3"></i> Agenda</a></li>
        <li><a href="<?= $base_url ?>/views/cadastrar_clientes.php"><i class="bi bi-people"></i> Clientes</a></li>
        <li><a href="<?= $base_url ?>/views/agendamento.php"><i class="bi bi-calendar-plus"></i> Agendamento</a></li>
        <li><a href="<?= $base_url ?>/views/relatorios.php" class="active"><i class="bi bi-clipboard-data"></i> Relatórios</a></li>
      </ul>
    </nav>

    <div class="logout">
      <a href="<?= $base_url ?>/controllers/LogoutController.php">Sair</a>
    </div>
  </aside>

  
  <main>
    <h1 class="dashboard-title">Relatórios</h1>

    <div class="rel-container">
      <form method="GET" class="rel-filters">
        <h3>Tipo de Relatório:</h3>
        <div class="filter-group">
          <select name="tipo" id="tipo">
            <option value="servicos_mais_solicitados">Serviços Mais Solicitados</option>
          </select>
        </div>

        <h3>Período:</h3>
        <div class="filter-group">
          <select name="periodo" id="periodo">
            <option value="mes" <?= $periodo == 'mes' ? 'selected' : '' ?>>Este Mês</option>
            <option value="semana" <?= $periodo == 'semana' ? 'selected' : '' ?>>Esta Semana</option>
            <option value="ano" <?= $periodo == 'ano' ? 'selected' : '' ?>>Este Ano</option>
            <option value="todos" <?= $periodo == 'todos' ? 'selected' : '' ?>>Todos</option>
          </select>
        </div>

        <button type="submit" class="btn-gerar"><i class="bi bi-graph-up"></i> Gerar Relatório</button>
      </form>

      <div class="rel-results">
        <div class="top">
          <h2>Resultados: Serviços Mais Solicitados</h2>
          <a class="export-btn" href="?periodo=<?= htmlspecialchars($periodo) ?>&export=xls">
            <i class="bi bi-file-earmark-excel"></i> Exportar .xls
          </a>
        </div>

        <table class="rel-table">
          <thead>
            <tr>
              <th>Serviço</th>
              <th>Quantidade</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($relatorios) > 0): ?>
              <?php foreach ($relatorios as $r): ?>
                <tr>
                  <td><?= htmlspecialchars($r['servico']) ?></td>
                  <td><?= htmlspecialchars($r['quantidade']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="2">Nenhum dado encontrado para o período selecionado.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
