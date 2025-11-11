<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    header('Location: login_form.php');
    exit();
}

$id_usuario = $_SESSION['id'];

$stmt_user = $conn->prepare("SELECT nome, email FROM cadastro_usuarios WHERE id = ?");
$stmt_user->bind_param("i", $id_usuario);
$stmt_user->execute();
$usuario = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

$stmt_enderecos = $conn->prepare("SELECT * FROM enderecos WHERE usuario_id = ? ORDER BY id");
$stmt_enderecos->bind_param("i", $id_usuario);
$stmt_enderecos->execute();
$enderecos = $stmt_enderecos->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_enderecos->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Açaí da Suíça</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/editar_perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
            <div class="logo-text"><h1>Editar Perfil</h1></div>
        </div>
        <nav>
            <a href="perfil.php" class="login-btn">Voltar ao Perfil</a>
            <a href="logout.php" class="login-btn">Sair</a>
        </nav>
    </header>

    <main class="container my-5">
        
        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success text-center"><?php echo $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger text-center"><?php echo $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?></div>
        <?php endif; ?>

        <div class="row g-4 justify-content-center">
    <!-- CARD: Alterar E-mail -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header"><h3><i class="fas fa-envelope"></i> Alterar E-mail</h3></div>
            <div class="card-body">
                <form action="atualizar_perfil.php" method="POST">
                    <input type="hidden" name="action" value="update_email">
                    <div class="mb-3">
                        <label for="email" class="form-label">Novo E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Salvar Novo E-mail</button>
                </form>
            </div>
        </div>
    </div>


               <!-- CARD: Alterar Senha -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header"><h3><i class="fas fa-lock"></i> Alterar Senha</h3></div>
            <div class="card-body">
                <form action="atualizar_perfil.php" method="POST">
                    <input type="hidden" name="action" value="update_password">
                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                    </div>
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirma_senha" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="confirma_senha" name="confirma_senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Salvar Nova Senha</button>
                </form>
            </div>
        </div>
    </div>

     <!-- CARD: Meus Endereços -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="fas fa-map-marker-alt"></i> Meus Endereços</h3>
                <?php if (count($enderecos) < 5): ?>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEndereco">
                        <i class="fas fa-plus"></i> Adicionar
                    </button>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($enderecos)): ?>
                    <p class="text-center">Nenhum endereço cadastrado.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($enderecos as $endereco): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($endereco['endereco']); ?>, <?php echo htmlspecialchars($endereco['numero']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($endereco['cep']); ?> - <?php echo htmlspecialchars($endereco['bairro']); ?></small>
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary btn-sm me-2"
                                            onclick="editarEndereco(<?php echo htmlspecialchars(json_encode($endereco)); ?>)">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <a href="atualizar_perfil.php?action=delete_address&id=<?php echo $endereco['id']; ?>"
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Tem certeza?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
           <!-- Fim dos Cards -->
    </main>

    <div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="modalEnderecoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="atualizar_perfil.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEnderecoLabel">Adicionar Novo Endereço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" id="enderecoAction" value="add_address">
                        <input type="hidden" name="endereco_id" id="enderecoId">
                        
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" required maxlength="9" placeholder="Digite apenas os números">
                            <div id="cepFeedback" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço (Rua)</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" required readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" required readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="referencia" class="form-label">Referência / Complemento</label>
                            <input type="text" class="form-control" id="referencia" name="referencia">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Endereço</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Js/editar_perfil.js"></script>
</body>
</html>