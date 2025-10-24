<?php
session_start();

// Se o usuário não estiver logado, redireciona para a página de login
if (!isset($_SESSION['id'])) {
    header('Location: login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos - Açaí da Suíça</title>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/meus_pedidos.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
            <div class="logo-text">
                <h1>Meus Pedidos</h1>
            </div>
        </div>
        <nav>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="cardapio.php">Cardápio</a>
                <a href="perfil.php">Meu Perfil</a>
            </div>
            <a href="logout.php" class="login-btn">Sair</a>
        </nav>
    </header>

    <main class="container my-5">
        <div class="pedidos-header">
            <h2>Histórico de Pedidos</h2>
            <p>Veja os detalhes dos seus últimos pedidos realizados no site.</p>
        </div>

        <div id="container-pedidos">
            <p class="text-center">Carregando seus pedidos...</p>
        </div>
    </main>

    <footer class="footer-dark">
      <div class="container py-4">
        <div class="footer-bottom text-center py-3" style="background: none;">
          © 2025 Açaí da Suíça | Todos os direitos reservados.
        </div>
      </div>
    </footer>

    <script src="Js/meus_pedidos.js"></script>
</body>
</html>