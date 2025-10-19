<?php
// Toda a sua lógica PHP de busca e salvamento continua aqui no topo...
include 'verifica_admin.php';
include 'conexao.php';

// --- INICIALIZAÇÃO DE VARIÁVEIS ---
$modo_edicao = false;
$item_id = null;
$item_nome = '';
$item_tipo = 'adicional_pago';
$item_preco = ''; // Começa como string vazia
$item_em_estoque = 1;
$titulo_pagina = 'Adicionar Nova Opção';
$texto_botao = 'Adicionar Opção';

// --- VERIFICA SE ESTAMOS EM MODO DE EDIÇÃO ---
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $modo_edicao = true;
    $item_id = $_GET['id'];
    $titulo_pagina = 'Editar Opção';
    $texto_botao = 'Salvar Alterações';

    $stmt = $conn->prepare("SELECT nome, tipo, preco, em_estoque FROM ingredientes WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();
    if ($item) {
        $item_nome = $item['nome'];
        $item_tipo = $item['tipo'];
        $item_preco = $item['preco']; // Pega o preço como vem do banco
        $item_em_estoque = $item['em_estoque'];
    } else {
        header('Location: painel_admin.php'); exit();
    }
    $stmt->close();
}

// --- PROCESSA O FORMULÁRIO QUANDO ENVIADO ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    // Converte vírgula para ponto para salvar no banco
    $preco = str_replace(',', '.', trim($_POST['preco'])) ?: 0.00;
    $em_estoque = isset($_POST['em_estoque']) ? 1 : 0;
    $id_para_salvar = $_POST['id'];

    if ($modo_edicao) {
        $stmt = $conn->prepare("UPDATE ingredientes SET nome = ?, tipo = ?, preco = ?, em_estoque = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $nome, $tipo, $preco, $em_estoque, $id_para_salvar);
    } else {
        $stmt = $conn->prepare("INSERT INTO ingredientes (nome, tipo, preco, em_estoque) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $nome, $tipo, $preco, $em_estoque);
    }

    if ($stmt->execute()) {
        header("Location: painel_admin.php");
        exit();
    } else {
        $erro = "Erro ao salvar a opção: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - Açaí da Suíça</title>

    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f0f7; }
        .admin-container { max-width: 700px; margin: 40px auto; padding: 30px; background-color: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .form-label { font-weight: 500; color: #333; }
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
            <div class="logo-text">
                <h1><?php echo $titulo_pagina; ?></h1>
            </div>
        </div>
        <nav>
            <a href="logout.php" class="login-btn">Sair</a>
        </nav>
    </header>

    <main class="admin-container">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($item_id); ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Opção</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($item_nome); ?>" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipo" class="form-label">Tipo de Opção</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="tamanho_copo" <?php if($item_tipo == 'tamanho_copo') echo 'selected'; ?>>Tamanho (Copo)</option>
                        <option value="tamanho_marmita" <?php if($item_tipo == 'tamanho_marmita') echo 'selected'; ?>>Tamanho (Marmita)</option>
                        <option value="complemento_gratis" <?php if($item_tipo == 'complemento_gratis') echo 'selected'; ?>>Complemento Grátis</option>
                        <option value="adicional_pago" <?php if($item_tipo == 'adicional_pago') echo 'selected'; ?>>Adicional Pago</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="preco" class="form-label">Preço (R$)</label>
                    <input type="text" class="form-control" id="preco" name="preco" 
                           value="<?php echo $modo_edicao ? htmlspecialchars(number_format($item_preco, 2, ',', '.')) : ''; ?>" 
                           placeholder="Ex: 15,50 ou 0">
                </div>
            </div>

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" role="switch" id="em_estoque" name="em_estoque" <?php if($item_em_estoque) echo 'checked'; ?>>
                <label class="form-check-label" for="em_estoque">Disponível em estoque</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="painel_admin.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn" style="background-color: #6f42c1; color: white;"><?php echo $texto_botao; ?></button>
            </div>
        </form>
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