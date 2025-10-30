<?php
ob_start(); 
require_once __DIR__ . '/../includes/config.php';


$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$pet = $_POST['pet'] ?? '';


if (empty($nome) || empty($telefone) || empty($endereco) || empty($pet)) {
    echo "<script>alert('Por favor, preencha todos os campos obrigatórios!'); history.back();</script>";
    exit();
}


$stmt = $conn->prepare("INSERT INTO clientes (nome, telefone, email, endereco, pet) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $telefone, $email, $endereco, $pet);

if ($stmt->execute()) {
    
    header("Location: {$base_url}/views/cadastrar_clientes_sucesso.php");
    exit();
} else {
    echo "<script>alert('Erro ao salvar o cliente.'); history.back();</script>";
}

$stmt->close();
$conn->close();
ob_end_flush();
?>
