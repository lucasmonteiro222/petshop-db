<?php
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';


$sql = "SELECT * FROM clientes ORDER BY nome ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Cliente - Petzen</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/cadastro.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/mensagens.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/pesquisa_tabela.css">
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
          <li><a href="<?= $base_url ?>/views/cadastrar_clientes.php" class="active"><i class="bi bi-people"></i> Clientes</a></li>
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
    <h1><i class="bi bi-person-plus"></i> Cadastro de Cliente</h1>

    <?php if (isset($_GET['msg'])): ?>
      <?php if ($_GET['msg'] === 'salvo'): ?>
        <div class="alert alert-success">✅ Cliente salvo com sucesso!</div>
      <?php elseif ($_GET['msg'] === 'editado'): ?>
        <div class="alert alert-success">✏️ Cliente atualizado com sucesso!</div>
      <?php elseif ($_GET['msg'] === 'excluido'): ?>
        <div class="alert alert-success">🗑️ Cliente excluído com sucesso!</div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="cadastro-e-lista">
      <form action="../controllers/SalvarClienteController.php" method="POST" class="form-cadastro">
        <label for="nome">Nome do Cliente</label>
        <input type="text" id="nome" name="nome" required>

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email">

        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="pet">Nome do Pet</label>
        <input type="text" id="pet" name="pet" required>

        <button type="submit"><i class="bi bi-save"></i> Salvar Cliente</button>
      </form>

      <section class="lista-clientes">
        <h2><i class="bi bi-list-ul"></i> Lista de Clientes</h2>

        <!-- Barra de pesquisa -->
        <input type="text" id="pesquisa" placeholder="🔍 Buscar cliente por nome..." class="campo-pesquisa">

        <div class="tabela-container">
          <table id="tabelaClientes">
            <thead>
              <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th>Pet</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; while ($c = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['telefone']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['endereco']) ?></td>
                <td><?= htmlspecialchars($c['pet']) ?></td>
                <td class="acoes">
                  <a href="editar_cliente.php?id=<?= $c['id_cliente'] ?>" title="Editar" class="btn-editar"><i class="bi bi-pencil-square"></i></a>
                  <a href="../controllers/ExcluirClienteController.php?id=<?= $c['id_cliente'] ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente?');" title="Excluir" class="btn-excluir"><i class="bi bi-trash3"></i></a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>

  <script>
   
  document.getElementById('pesquisa').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    const linhas = document.querySelectorAll('#tabelaClientes tbody tr');
    linhas.forEach(linha => {
      const nome = linha.cells[1].textContent.toLowerCase();
      linha.style.display = nome.includes(filtro) ? '' : 'none';
    });
  });
  </script>
</body>
</html>
