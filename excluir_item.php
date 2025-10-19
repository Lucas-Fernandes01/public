<?php
// 1. SEGURANÇA: Verifica se quem está acessando é um administrador.
// Se não for, o script para aqui e redireciona para a página de login.
include 'verifica_admin.php';

// 2. CONEXÃO: Inclui o arquivo para se conectar ao banco de dados.
include 'conexao.php';

// 3. VERIFICAÇÃO: Checa se um 'id' foi passado pela URL (ex: excluir_item.php?id=7).
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Converte o ID para um número inteiro para maior segurança.
    $item_id = intval($_GET['id']);

    // 4. PREPARAÇÃO DA QUERY SQL
    // Prepara o comando para deletar da tabela 'ingredientes' onde o 'id' corresponder.
    $sql = "DELETE FROM ingredientes WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    
    // Vincula o ID à query para evitar qualquer risco de SQL Injection.
    // "i" significa que o parâmetro é um inteiro (integer).
    $stmt->bind_param("i", $item_id);

    // 5. EXECUÇÃO
    // Executa a query. Se tudo der certo, a linha é removida do banco.
    $stmt->execute();

    // Fecha o statement.
    $stmt->close();
}

// Fecha a conexão com o banco.
$conn->close();

// 6. REDIRECIONAMENTO
// Não importa o que aconteceu, no final, sempre redireciona o admin de volta
// para o painel para que ele veja a lista de itens atualizada.
header("Location: painel_admin.php");
exit(); // Garante que o script pare de ser executado após o redirecionamento.
?>