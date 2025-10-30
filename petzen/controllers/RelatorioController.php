<?php
require_once __DIR__ . '/../includes/config.php';

$tipoFiltro = $_GET['filtro'] ?? 'todos';
$condicao = '';

switch ($tipoFiltro) {
    case 'semana':
        $condicao = "WHERE YEARWEEK(a.data_hora, 1) = YEARWEEK(NOW(), 1)";
        break;
    case 'mes':
        $condicao = "WHERE MONTH(a.data_hora) = MONTH(NOW()) AND YEAR(a.data_hora) = YEAR(NOW())";
        break;
    case 'ano':
        $condicao = "WHERE YEAR(a.data_hora) = YEAR(NOW())";
        break;
    default:
        $condicao = ""; // todos
}

$sql = "SELECT a.servico, COUNT(*) AS total
        FROM agendamentos a
        $condicao
        GROUP BY a.servico";

$result = $conn->query($sql);
$dados = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($dados);
