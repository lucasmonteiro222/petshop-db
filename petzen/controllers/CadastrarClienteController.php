<?php
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');

$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$pet = $_POST['pet'] ?? '';

if ($nome && $telefone && $pet) {
    $stmt = $conn->prepare("INSERT INTO clientes (nome, telefone, email, endereco, pet) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $telefone, $email, $endereco, $pet);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
