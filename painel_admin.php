<?php
// Inclui o nosso "segurança" para garantir que apenas administradores acessem esta página.
include 'verifica_admin.php';
// Inclui a conexão com o banco para podermos buscar os dados.
include 'conexao.php';

// Busca os itens da nova tabela 'ingredientes'
$sql = "SELECT id, nome, preco, tipo, em_estoque FROM ingredientes ORDER BY tipo, nome";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador - Açaí da Suíça</title>
    
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f4f0f7; }
        .admin-container { max-width: 1000px; margin: 40px auto; padding: 30px; background-color: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #dee2e6; padding-bottom: 15px; flex-wrap: wrap; gap: 10px; }
        .admin-header h2 { color: #4b0055; font-weight: 600; margin: 0; }
        .btn-add { background-color: #6f42c1; color: white; padding: 8px 15px; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background-color 0.3s; }
        .btn-add:hover { background-color: #5a379f; color: white; }
        .table th { background-color: #451761; color: #fff; }
        .action-links a { margin-right: 10px; text-decoration: none; font-weight: 500; }
        .action-links .edit { color: #0d6efd; }
        .action-links .delete { color: #dc3545; }
        .estoque-sim { color: #198754; font-weight: bold; }
        .estoque-nao { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    
    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
            <div class="logo-text">
                <h1>Painel Administrativo</h1>
            </div>
        </div>
        <nav>
            <a href="index.php" class="login-btn" style="background: #6c757d; box-shadow: none;">Ver Site</a>
            <a href="logout.php" class="login-btn">Sair</a>
        </nav>
    </header>

    <main class="admin-container">
        <div class="admin-header">
            <h2>Gerenciamento de Opções</h2>
            <div>
                <a href="pedidos_admin.php" class="btn-add" style="background-color: #0d6efd;">Ver Pedidos</a>
                <a href="editar_item.php" class="btn-add">Adicionar Opção</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome da Opção</th>
                        <th>Tipo</th>
                        <th>Preço</th>
                        <th>Em Estoque?</th>
                        <th style="width: 120px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <?php while($item = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td><?php echo htmlspecialchars($item['tipo']); ?></td>
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td>
                                <span class="<?php echo $item['em_estoque'] ? 'estoque-sim' : 'estoque-nao'; ?>">
                                    <?php echo $item['em_estoque'] ? 'Sim' : 'Não'; ?>
                                </span>
                            </td>
                            <td class="action-links">
                                <a href="editar_item.php?id=<?php echo $item['id']; ?>" class="edit">Editar</a>
                                <a href="excluir_item.php?id=<?php echo $item['id']; ?>" class="delete" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma opção cadastrada.</td>
                        </tr>
                    <?php endif; $conn->close(); ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer-dark">
        <div class="container py-4">
            <div class="footer-bottom text-center py-3" style="background: none;">
                © 2025 Açaí da Suíça | Painel Administrativo
            </div>
        </div>
    </footer>

</body>
</html>