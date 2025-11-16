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
$primeiro_item = $carrinho[0]; // Pega o primeiro item para dados gerais
$tipo_entrega = $primeiro_item['entrega'] ?? 'Não especificado'; 

// --- MUDANÇA AQUI: Captura o snapshot do endereço ---
$endereco_snapshot = 'Retirar na loja'; // Define um padrão
if ($tipo_entrega === 'Delivery' && isset($primeiro_item['enderecoCompleto'])) {
    $endereco_str = $primeiro_item['enderecoCompleto'] ?? 'Endereço não informado';
    $cep_str = $primeiro_item['cep'] ?? '';
    // Formata o snapshot
    $endereco_snapshot = $endereco_str . " - " . $cep_str;
}
// --- FIM DA MUDANÇA ---

// Calcula o valor total do pedido somando o valor de cada item
foreach ($carrinho as $item) {
    $valor_total_pedido += $item['valor'];
}

// --- MUDANÇA AQUI: Adiciona 'endereco_entrega' na query ---
// (Sua migration já deve ter criado esta coluna)
$sql_pedido_mestre = "INSERT INTO pedidos (usuario_id, valor_total, tipo_entrega, endereco_entrega) VALUES (?, ?, ?, ?)";
$stmt_mestre = $conn->prepare($sql_pedido_mestre);

// --- MUDANÇA AQUI: Adiciona "s" (string) para o novo campo $endereco_snapshot ---
$stmt_mestre->bind_param("idss", $id_usuario, $valor_total_pedido, $tipo_entrega, $endereco_snapshot);

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