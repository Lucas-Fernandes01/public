<?php
include 'verifica_admin.php';
include 'conexao.php';

header('Content-Type: application/json');

$pedidos_finais = [];

// SQL que junta 'pedidos' com 'cadastro_usuarios' para pegar o nome do cliente
$sql_pedidos = "
    SELECT 
        p.id, p.valor_total, p.tipo_entrega, p.status, p.data_pedido,
        u.nome as nome_cliente, u.endereco, u.bairro, u.numero
    FROM pedidos p
    JOIN cadastro_usuarios u ON p.usuario_id = u.id
    ORDER BY p.data_pedido DESC";

$resultado_pedidos = $conn->query($sql_pedidos);

if ($resultado_pedidos) {
    $sql_itens = "SELECT tipo, tamanho, complementos, adicionais, observacao, valor_item FROM pedido_itens WHERE pedido_id = ?";
    $stmt_itens = $conn->prepare($sql_itens);

    while ($pedido = $resultado_pedidos->fetch_assoc()) {
        $stmt_itens->bind_param("i", $pedido['id']);
        $stmt_itens->execute();
        $resultado_itens = $stmt_itens->get_result();
        
        $itens_do_pedido = [];
        while ($item = $resultado_itens->fetch_assoc()) {
            $itens_do_pedido[] = $item;
        }
        
        $pedido['itens'] = $itens_do_pedido;
        $pedidos_finais[] = $pedido;
    }
    $stmt_itens->close();
}

$conn->close();
echo json_encode($pedidos_finais);
?>