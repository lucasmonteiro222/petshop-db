<?php
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';


$sql = "SELECT a.*, c.nome AS cliente_nome 
        FROM agendamentos a
        LEFT JOIN clientes c ON a.id_cliente = c.id_cliente
        ORDER BY a.data_hora ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Erro ao buscar agendamentos: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda - Petzen</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/agenda.css">
  <style>
    .acoes { display: flex; gap: 6px; justify-content: center; }
    .btn {
      border: none;
      border-radius: 8px;
      padding: 6px 10px;
      color: #fff;
      font-size: 14px;
      cursor: pointer;
      transition: 0.2s;
    }
    .btn-editar { background-color: #007bff; }
    .btn-editar:hover { background-color: #0056b3; }
    .btn-excluir { background-color: #dc3545; }
    .btn-excluir:hover { background-color: #a71d2a; }
    .status-select {
      border-radius: 6px;
      padding: 5px;
      border: 1px solid #ccc;
      background-color: #f9f9f9;
      cursor: pointer;
    }
  </style>
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
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
      <div class="alerta-sucesso">
        <i class="bi bi-check-circle"></i> Agendamento salvo com sucesso!
      </div>
    <?php endif; ?>

    <div class="agenda-header">
      <h2>Agenda</h2>
      <div class="agenda-controls">
        <a href="<?= $base_url ?>/views/agendamento.php" class="add-btn">
          <i class="bi bi-calendar-plus"></i> Novo Agendamento
        </a>
      </div>
    </div>

    <section class="agenda-lista">
      <table class="agenda-table">
        <thead>
          <tr>
            <th>Data e Hora</th>
            <th>Cliente</th>
            <th>Serviço</th>
            <th>Status</th>
            <th>Observações</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($a = $result->fetch_assoc()): ?>
              <tr>
                <td><?= date('d/m/Y H:i', strtotime($a['data_hora'])) ?></td>
                <td><?= htmlspecialchars($a['cliente_nome'] ?? '—') ?></td>
                <td><?= htmlspecialchars($a['servico']) ?></td>
                <td>
                  <form action="../controllers/AtualizarAgendamentoController.php" method="POST">
                    <input type="hidden" name="id_agendamento" value="<?= $a['id_agendamento'] ?>">
                    <select name="status" class="status-select" onchange="this.form.submit()">
                      <option value="Agendado" <?= $a['status'] == 'Agendado' ? 'selected' : '' ?>>Agendado</option>
                      <option value="Concluído" <?= $a['status'] == 'Concluído' ? 'selected' : '' ?>>Concluído</option>
                      <option value="Cancelado" <?= $a['status'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                  </form>
                </td>
                <td><?= htmlspecialchars($a['observacoes']) ?></td>
                <td class="acoes">
                  <a href="<?= $base_url ?>/views/editar_agendamento.php?id=<?= $a['id_agendamento'] ?>" class="btn btn-editar" title="Editar"><i class="bi bi-pencil"></i></a>
                  <form action="../controllers/ExcluirAgendamentoController.php" method="POST" onsubmit="return confirm('Deseja excluir este agendamento?');" style="display:inline;">
                    <input type="hidden" name="id_agendamento" value="<?= $a['id_agendamento'] ?>">
                    <button type="submit" class="btn btn-excluir" title="Excluir"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6">Nenhum agendamento encontrado.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
