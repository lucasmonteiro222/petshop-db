<?php
require_once __DIR__ . '/../includes/config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: ../views/cadastrar_clientes.php?msg=excluido");
        exit;
    } else {
        echo "Erro ao excluir cliente.";
    }
} else {
    header("Location: ../views/cadastrar_clientes.php");
    exit;
}
