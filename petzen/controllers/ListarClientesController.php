<?php
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT id_cliente, nome, telefone, email, pet FROM clientes ORDER BY id_cliente DESC");
$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}
echo json_encode($clientes);
