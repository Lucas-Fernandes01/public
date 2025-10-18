<?php
session_start();

// Se o usuário não estiver logado, redireciona para a página de login.
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionais para a página de perfil */
        .perfil-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .card-pedido-header, .card-pedido-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.item-do-pedido {
    border-left: 3px solid #6f42c1;
    padding-left: 10px;
    margin-bottom: 10px;
}
.item-do-pedido p {
    margin-bottom: 2px;
}
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo"/>
            <div class="logo-text"><h1>Sabor que conquista</h1></div>
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
        <h1>Bem-vindo(a) de volta, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
        <p>Aqui você pode ver seu histórico de pedidos e gerenciar sua conta.</p>
        <hr>

        <h2>Meus Últimos Pedidos</h2>
        <div id="container-pedidos">
            <p>Carregando seu histórico de pedidos...</p>
        </div>
    </main>

    <footer class="footer-dark">
      <div class="container py-5">
        <div class="row">
    
          <!-- Sobre -->
          <div class="col-md-3">
            <h5>Açaí da Suíça</h5>
            <p>Mais que sabor, uma experiência. Feito com carinho para conquistar você do seu jeito.</p>
            <a href="quem_somos.php" class="read-more">saiba mais →</a>
          </div>
    
          <!-- Contato -->
          <div class="col-md-3">
            <h5>Contato</h5>
            <ul class="list-unstyled">
              <li><i class="fas fa-map-marker-alt"></i> Nova Suiça, Piracicaba - SP</li>
              <li><i class="fas fa-phone"></i> (19) 99951-0173</li>
              <li><i class="fas fa-envelope"></i> contato@acaidasuica.com.br</li>
            </ul>
          </div>
    
          <!-- Horário -->
          <div class="col-md-3">
            <h5>Funcionamento</h5>
            <ul class="list-unstyled">
              <li>Seg a Sex: 17h - 22h</li>
              <li>Domingo: 14h - 22h</li>
            </ul>
          </div>
    
          <!-- Mapa  e Social -->
<div class="col-md-3">
  <h5>Encontre-nos</h5>
  <div class="footer-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.5749843614562!2d-47.69305532574842!3d-22.744033432072634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c637fa6843c5bf%3A0x78c6c3677d48448a!2zQcOnYWkgZGEgU3Vpw6dh!5e0!3m2!1spt-BR!2sbr!4v1751499566388!5m2!1spt-BR!2sbr"
    width="100%"
    height="180"
    style="border:0;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">  
  </iframe>
  </div>
</div>
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <!-- Bootstrap JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>
</html>

    <script src="js/meus_pedidos.js"></script>
</body>
</html>