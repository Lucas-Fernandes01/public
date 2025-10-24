<?php
include 'verifica_admin.php'; // Garante que só admin acesse
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos dos Clientes - Painel Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pedidos_admin.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
            <div class="logo-text"><h1>Pedidos dos Clientes</h1></div>
        </div>
        <nav>
            <a href="painel_admin.php" class="login-btn">Voltar ao Painel</a>
            <a href="logout.php" class="login-btn">Sair</a>
        </nav>
    </header>

    <main class="container my-5">
        <div class="pedidos-header">
            <h2>Gerenciamento de Pedidos</h2>
            <p>Visualize e atualize o status dos pedidos recebidos.</p>
        </div>
        <div id="container-pedidos-admin">
            <p class="text-center">Carregando pedidos...</p>
        </div>
    </main>
    
    <footer class="footer-dark">
        <div class="container py-4">
            <div class="footer-bottom text-center py-3" style="background: none;">
                © 2025 Açaí da Suíça | Painel Administrativo
            </div>
        </div>
    </footer>

    <script src="Js/pedidos_admin.js"></script> </body>
</html>