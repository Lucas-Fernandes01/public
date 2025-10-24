<?php
session_start();
include "conexao.php";

header('Content-Type: application/json');

// Proteção: verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401); // Não autorizado
    echo json_encode(['erro' => 'Usuário não autenticado.']);
    exit();
}

$id_do_usuario_logado = $_SESSION['id'];
$pedidos_finais = [];

// 1. QUERY CORRIGIDA: Agora seleciona o campo 'status'
$sql_pedidos = "SELECT id, valor_total, tipo_entrega, status, data_pedido FROM pedidos WHERE usuario_id = ? ORDER BY data_pedido DESC";
$stmt_pedidos = $conn->prepare($sql_pedidos);
$stmt_pedidos->bind_param("i", $id_do_usuario_logado);
$stmt_pedidos->execute();
$resultado_pedidos = $stmt_pedidos->get_result();

if ($resultado_pedidos) {
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
    
    $stmt_itens->close();
}

$stmt_pedidos->close();
$conn->close();

// Retorna o resultado completo como JSON
echo json_encode($pedidos_finais);
?>