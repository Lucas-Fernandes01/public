<?php
session_start();
include "conexao.php";

header('Content-Type: application/json');

// Proteção: verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401); // Não autorizado
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado.']);
    exit();
}

// Pega o ID do pedido enviado pelo JavaScript
$data = json_decode(file_get_contents("php://input"), true);
$pedido_id = $data['pedido_id'] ?? null;
$id_usuario = $_SESSION['id'];

if (!$pedido_id) {
    http_response_code(400); // Requisição inválida
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do pedido não fornecido.']);
    exit();
}

// Prepara a query para atualizar o status do pedido
// IMPORTANTE: A condição "AND usuario_id = ?" garante que um usuário só pode cancelar os próprios pedidos
$sql = "UPDATE pedidos SET status = 'Cancelado' WHERE id = ? AND usuario_id = ? AND status = 'Em preparação'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pedido_id, $id_usuario);

if ($stmt->execute()) {
    // Verifica se alguma linha foi realmente afetada
    if ($stmt->affected_rows > 0) {
        echo json_encode(['sucesso' => true, 'mensagem' => 'Pedido cancelado com sucesso!']);
    } else {
        // Isso acontece se o pedido não pertence ao usuário, não existe ou já não está "Em preparação"
        http_response_code(403); // Proibido
        echo json_encode(['sucesso' => false, 'mensagem' => 'Você não tem permissão para cancelar este pedido ou ele não pode mais ser cancelado.']);
    }
} else {
    http_response_code(500); // Erro do servidor
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao processar o cancelamento.']);
}

$stmt->close();
$conn->close();
?>