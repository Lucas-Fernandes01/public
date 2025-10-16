<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Usuário não autenticado.']);
    exit();
}

$id_do_usuario_logado = $_SESSION['id'];
$pedidos_finais = [];

// 1. Busca todos os PEDIDOS MESTRES do usuário
$sql_pedidos = "SELECT id, valor_total, tipo_entrega, data_pedido FROM pedidos WHERE usuario_id = ? ORDER BY data_pedido DESC";
$stmt_pedidos = $conn->prepare($sql_pedidos);
$stmt_pedidos->bind_param("i", $id_do_usuario_logado);
$stmt_pedidos->execute();
$resultado_pedidos = $stmt_pedidos->get_result();

// Prepara a query para buscar os itens
$sql_itens = "SELECT tipo, tamanho, complementos, adicionais, observacao, valor_item FROM pedido_itens WHERE pedido_id = ?";
$stmt_itens = $conn->prepare($sql_itens);

// 2. Para cada pedido mestre, busca seus itens
while ($pedido = $resultado_pedidos->fetch_assoc()) {
    $stmt_itens->bind_param("i", $pedido['id']);
    $stmt_itens->execute();
    $resultado_itens = $stmt_itens->get_result();
    
    $itens_do_pedido = [];
    while ($item = $resultado_itens->fetch_assoc()) {
        $itens_do_pedido[] = $item;
    }
    
    // Adiciona o array de itens dentro do objeto do pedido
    $pedido['itens'] = $itens_do_pedido;
    $pedidos_finais[] = $pedido;
}

$stmt_pedidos->close();
$stmt_itens->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($pedidos_finais);
?>