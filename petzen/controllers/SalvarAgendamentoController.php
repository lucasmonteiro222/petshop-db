<?php
require_once __DIR__ . '/../includes/config.php';
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_cliente = $_POST['id_cliente'];
    $servico = $_POST['servico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    
    $data_hora = $data . ' ' . $hora . ':00';
    $status = 'Agendado';
    $observacoes = null;

 
    $stmt = $conn->prepare("
        INSERT INTO agendamentos (data_hora, servico, status, observacoes, id_cliente)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $data_hora, $servico, $status, $observacoes, $id_cliente);

    
    if ($stmt->execute()) {
        header("Location: ../views/agenda.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao salvar agendamento: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
