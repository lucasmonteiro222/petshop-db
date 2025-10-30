<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Petzen</title>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

  <header class="topbar">
    <div class="logo-area">
      <img src="../img/logo.png" alt="Logo Petzen">
      <h1>PETZEN</h1>
    </div>
    <h2>SISTEMA DE GESTÃO INTERNA</h2>
    <div class="secure-area">
      <i class="lock">🔒</i>
      <span>Ambiente Seguro</span>
    </div>
  </header>

  <main>
    <div class="login-container">
      <h2>Acesse sua conta</h2>

      <?php if (!empty($erro)): ?>
        <p class="erro"><?= htmlspecialchars($erro) ?></p>
      <?php endif; ?>
      
      <form action="../controllers/LoginController.php" method="POST">
        <label for="email">Usuário</label>
        <input type="email" id="email" name="email" placeholder="Digite seu usuário (e-mail)" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

        <button type="submit">ENTRAR</button>
      </form>

      <p class="copy">Copyright© 2025 Petzen - todos os direitos reservados</p>
    </div>
  </main>

</body>
</html>
