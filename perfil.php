<?php
session_start();

// Se o usuário não estiver logado de forma alguma, redireciona para o login.
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
    <title>Meu Perfil - Açaí da Suíça</title>
    
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f0f7; }
        .perfil-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center; /* Centraliza o conteúdo */
        }
        .perfil-header h1 {
            color: #4b0055;
            font-weight: 600;
        }
        .admin-button {
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 30px;
            padding: 12px 25px;
            background-color: #0d6efd; /* Um azul para destacar */
            color: white;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .admin-button:hover {
            background-color: #0b5ed7;
            color: white;
        }
        .logout-link {
            color: #dc3545;
            font-weight: 500;
            text-decoration: none;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
            <div class="logo-text">
                <h1>Meu Perfil</h1>
            </div>
        </div>
        <nav>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="cardapio.php">Cardápio</a>
                <a href="quem_somos.php">Quem Somos</a>
                <a href="contato.php">Contato</a>
            </div>
            <a href="logout.php" class="login-btn">Sair</a>
        </nav>
    </header>

    <main class="perfil-container">
        <div class="perfil-header">
            <h1>Bem-vindo(a) de volta, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
            <p class="lead text-muted">Gerencie suas informações e pedidos aqui.</p>
        </div>

        <hr class="my-4">

        <?php
        // AQUI ESTÁ A MÁGICA!
        // Verificamos se a sessão 'tipo_usuario' existe e se o valor dela é 'admin'.
        if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin') {
            // Se for admin, mostramos o botão que leva para o painel.
            echo '<a href="painel_admin.php" class="admin-button">Acessar Painel de Administrador</a>';
        }
        ?>

        <div id="secao-meus-dados">
            <h2>Meus Dados</h2>
            <p>Em breve, aqui você poderá editar seu nome, e-mail e senha.</p>
            </div>

        <hr class="my-4">

        <div id="secao-meus-enderecos">
            <h2>Meus Endereços</h2>
            <p>Em breve, aqui você poderá adicionar, editar e remover seus endereços de entrega.</p>
            </div>
        
        <hr class="my-4">

        <div id="secao-ultimos-pedidos">
            <h2>Últimos Pedidos</h2>
            <div id="container-pedidos">
                <p>Carregando seus pedidos...</p>
            </div>
        </div>

    </main>

    <footer class="footer-dark">
      <div class="container py-5">
        <div class="row">
          <div class="col-md-3"><h5>Açaí da Suíça</h5><p>Mais que sabor, uma experiência...</p><a href="quem_somos.php" class="read-more">saiba mais →</a></div>
          <div class="col-md-3"><h5>Contato</h5><ul class="list-unstyled"><li><i class="fas fa-map-marker-alt"></i> Nova Suiça, Piracicaba - SP</li><li><i class="fas fa-phone"></i> (19) 99951-0173</li><li><i class="fas fa-envelope"></i> contato@acaidasuica.com.br</li></ul></div>
          <div class="col-md-3"><h5>Funcionamento</h5><ul class="list-unstyled"><li>Seg a Sex: 17h - 22h</li><li>Domingo: 14h - 22h</li></ul></div>
          <div class="col-md-3"><h5>Encontre-nos</h5><div class="footer-map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.5749843614562!2d-47.69305532574842!3d-22.744033432072634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c637fa6843c5bf%3A0x78c6c3677d48448a!2zQcOnYWkgZGEgU3Vpw6dh!5e0!3m2!1spt-BR!2sbr!4v1751499566388!5m2!1spt-BR!2sbr" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div></div>
            <div class="social-icons mt-4">
              <h5>Siga-nos</h5>
              <a href="https://www.instagram.com/acai_dasuica/"><i class="bi bi-instagram"></i></a>
              <a href="https://www.facebook.com/profile.php?id=100093101157318"><i class="bi bi-facebook"></i></a>
              <a href="https://api.whatsapp.com/send/?phone=5519999510173&text&type=phone_number&app_absent=0"><i class="bi bi-whatsapp"></i></a>
              <a href="https://www.tiktok.com/@acai.da.suica"><i class="bi bi-tiktok"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom text-center py-3">
        © 2025 Açaí da Suíça | Todos os direitos reservados.
      </div>
    </footer>
    
    <script src="js/meus_pedidos.js"></script>

</body>
</html>