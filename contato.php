<?php
// Apenas iniciamos a sessão para verificar o status de login mais tarde
session_start(); 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Açaí da Suíça</title>
 <link rel="stylesheet" href="css/style.css" />
 <link rel="stylesheet" href="css/contato.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-HJ9mI+qV...sUA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <script src="Js/script.js"></script>
</head>
<body>
  <header>


    <div class="logo-container">
      <img src="Img/Logo.png" alt="Açaí da Suíça Logo" class="logo">
      <div class="logo-text">
        <h1>Sabor que conquista</h1>
      </div>
    </div>

  <nav>
    <div class="nav-links">
      <a href="index.php">Início</a>
      <a href="cardapio.php">Cardápio</a>
      <a href="quem-somos.php">Quem Somos</a>
      <a href="contato.php" class="active">Contato</a>
    </div>

      <?php if (isset($_SESSION['id'])): ?>
        <a href="perfil.php" class="login-btn">Meu Perfil</a>
      <?php else: ?>
        <a href="login_form.php" class="login-btn">Fazer Login</a>
      <?php endif; ?>

  </nav>
  </header>


   <main class="contato-page">
    <section class="contato-header">
      <h1>Fale Conosco</h1>
      <p>Estamos prontos para te atender!</p>
    </section>

    <section class="contato-info">
      <div class="info-item">
        <h3>Endereço</h3>
        <p> convívio Santa Tereza - R. Bárbara do Amaral Campos, 40</p>
      </div>
      <div class="info-item">
        <h3>Telefone</h3>
        <p>(19) 99951-0173</p>
      </div>
      <div class="info-item">
        <h3>Email</h3>
        <p>contato@acaidasuica.com</p>
      </div>
      <div class="info-item">
        <h3>Horário de Funcionamento</h3>
        <p>Seg a Sex: 17H às 22h</p>
         <p>Dom: 14h às 22h</p>
      </div>
    </section>

    <section class="contato-form">
      <h2>Envie uma Mensagem</h2>
      <form action="enviar.php" method="post" class="form-box">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="mensagem">Mensagem:</label>
        <textarea id="mensagem" name="mensagem" rows="4" required></textarea>

        <button type="submit">Enviar Mensagem</button>
      </form>
    </section>

    <section class="contato-mapa">
      <h2>Nos Encontre</h2>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.7772572043214!2d-47.64897158496181!3d-22.727867837502437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c63252e80f97ab%3A0xb7f62b4e4c70d868!2sPiracicaba%2C%20SP!5e0!3m2!1spt-BR!2sbr!4v1717695846880!5m2!1spt-BR!2sbr"
        width="100%"
        height="300"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
      </iframe>
    </section>

    <section class="contato-redes">
      <h2>Siga a gente nas redes</h2>
      <div class="redes-links">
        <a href="https://www.facebook.com/profile.php?id=100093101157318"><i class="fab fa-facebook-f"></i> Facebook</a>
        <a href="https://www.instagram.com/acai_dasuica/"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="https://api.whatsapp.com/send/?phone=5519999510173&text&type=phone_number&app_absent=0"><i class="fab fa-whatsapp"></i> WhatsApp</a>
      </div>
    </section>
  </main>

  <footer class="footer-dark">
      <div class="container py-5">
        <div class="row">
    
          <!-- Sobre -->
          <div class="col-md-3">
            <h5>Açaí da Suíça</h5>
            <p>Mais que sabor, uma experiência. Feito com carinho para conquistar você do seu jeito.</p>
            <a href="#" class="read-more">saiba mais →</a>
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