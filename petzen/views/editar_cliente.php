<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';


if (!isset($_GET['id'])) {
    die("ID do cliente não informado.");
}

$id = intval($_GET['id']);


$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cliente não encontrado.");
}

$cliente = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Cliente - Petzen</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/cadastro.css">
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
    <h1><i class="bi bi-pencil"></i> Editar Cliente</h1>

    <div class="cadastro-e-lista">
      <form action="../controllers/AtualizarClienteController.php" method="POST" class="form-cadastro">
        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

        <label for="nome">Nome do Cliente</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">

        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>" required>

        <label for="pet">Nome do Pet</label>
        <input type="text" id="pet" name="pet" value="<?= htmlspecialchars($cliente['pet']) ?>" required>

        <button type="submit"><i class="bi bi-save"></i> Salvar Alterações</button>
        <a href="cadastrar_clientes_sucesso.php" class="voltar"><i class="bi bi-arrow-left"></i> Voltar</a>
      </form>
    </div>
  </main>
</body>
</html>
