<?php
session_start();
require_once __DIR__ . '/../models/LoginModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $usuario = LoginModel::autenticar($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];
        
        header('Location: ../views/dashboard.php');
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
        include __DIR__ . '/../views/login.php';
        exit;
    }
} else {
    include __DIR__ . '/../views/login.php';
}
?>
