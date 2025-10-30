<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_cliente']);
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $pet = $_POST['pet'];

    $sql = "UPDATE clientes 
            SET nome = ?, telefone = ?, email = ?, endereco = ?, pet = ?
            WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $nome, $telefone, $email, $endereco, $pet, $id);

    if ($stmt->execute()) {
        header("Location: ../views/cadastrar_clientes.php?msg=editado");
        exit;
    } else {
        echo "Erro ao atualizar cliente.";
    }
} else {
    header("Location: ../views/cadastrar_clientes.php");
    exit;
}

