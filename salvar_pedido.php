<?php
session_start();
include "conexao.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado.']);
    exit();
}

// Pega os dados JSON do carrinho enviados pelo JavaScript
$json_data = file_get_contents('php://input');
$carrinho = json_decode($json_data, true);

if (empty($carrinho)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Carrinho vazio.']);
    exit();
}

// --- LÓGICA DE SALVAMENTO EM DUAS PARTES ---

// 1. INSERIR O PEDIDO MESTRE
$id_usuario = $_SESSION['id'];
$valor_total_pedido = 0;
// Pega a entrega do primeiro item (geralmente é a mesma para todos)
$tipo_entrega = $carrinho[0]['entrega'] ?? 'Não especificado'; 

// Calcula o valor total do pedido somando o valor de cada item
foreach ($carrinho as $item) {
    $valor_total_pedido += $item['valor'];
}

// Insere na tabela principal 'pedidos'
$sql_pedido_mestre = "INSERT INTO pedidos (usuario_id, valor_total, tipo_entrega) VALUES (?, ?, ?)";
$stmt_mestre = $conn->prepare($sql_pedido_mestre);
$stmt_mestre->bind_param("ids", $id_usuario, $valor_total_pedido, $tipo_entrega);

if ($stmt_mestre->execute()) {
    // Pega o ID do pedido que acabamos de criar. Isso é CRUCIAL!
    $novo_pedido_id = $conn->insert_id;

    // 2. INSERIR CADA ITEM DO CARRINHO
    $sql_itens = "INSERT INTO pedido_itens (pedido_id, tipo, tamanho, complementos, adicionais, observacao, valor_item) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_itens = $conn->prepare($sql_itens);

    foreach ($carrinho as $item) {
        $complementos_str = implode(', ', $item['complementos']);
        $adicionais_str = implode(', ', $item['adicionais']);

        $stmt_itens->bind_param("isssssd",
            $novo_pedido_id, // Liga o item ao pedido mestre
            $item['tipo'],
            $item['tamanho'],
            $complementos_str,
            $adicionais_str,
            $item['observacao'],
            $item['valor']
        );
        $stmt_itens->execute();
    }

    $stmt_itens->close();
    echo json_encode(['sucesso' => true, 'mensagem' => 'Pedido salvo com sucesso!', 'pedido_id' => $novo_pedido_id]);

} else {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar o pedido principal.']);
}

$stmt_mestre->close();
$conn->close();
?>