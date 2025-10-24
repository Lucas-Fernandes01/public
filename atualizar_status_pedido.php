<?php
include 'verifica_admin.php';
include 'conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$pedido_id = $data['pedido_id'] ?? null;
$novo_status = $data['novo_status'] ?? null;

if (!$pedido_id || !$novo_status) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
    exit();
}

// Lista de status permitidos para segurança
$status_permitidos = ['Em preparação', 'A caminho', 'Entregue', 'Cancelado'];
if (!in_array($novo_status, $status_permitidos)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Status inválido.']);
    exit();
}

$sql = "UPDATE pedidos SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $novo_status, $pedido_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(['sucesso' => true, 'mensagem' => 'Status do pedido atualizado com sucesso!']);
} else {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar o status ou o status já era o mesmo.']);
}

$stmt->close();
$conn->close();
?>