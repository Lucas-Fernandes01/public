<?php
// Iniciamos a sessão para verificar o status de login e usar as mensagens de feedback
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
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="Js/script.js"></script>
</head>
<body>
  <header>
    <div class="logo-container">
      <img src="Img/logo2.jpeg" alt="Açaí da Suíça Logo" class="logo">
      <div class="logo-text">
        <h1>Sabor que conquista</h1>
      </div>
    </div>

  <nav>
    <div class="nav-links">
      <a href="index.php">Início</a>
      <a href="cardapio.php">Cardápio</a>
      <a href="quem_somos.php">Quem Somos</a>
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

    <?php
    // Bloco que mostra a mensagem de sucesso ou erro vinda do 'enviar.php'
    if (isset($_SESSION['mensagem_contato'])) {
        $tipo_mensagem = $_SESSION['mensagem_contato_tipo'] ?? 'erro';
        echo '<div class="mensagem-status ' . htmlspecialchars($tipo_mensagem) . '">' . htmlspecialchars($_SESSION['mensagem_contato']) . '</div>';
        unset($_SESSION['mensagem_contato']);
        unset($_SESSION['mensagem_contato_tipo']);
    }
    ?>

    <?php if (isset($_SESSION['id']) && isset($_SESSION['nome'])): // SÓ MOSTRA O FORMULÁRIO SE O USUÁRIO ESTIVER LOGADO ?>
    
<section id="valores" class="secao-padrao">
  <h2 class="titulo-secao" data-aos="fade-up">Nossos Valores</h2>

  <div class="valores-container">
    <div class="valor-card" data-aos="zoom-in" data-aos-delay="100">
      <img src="https://img.icons8.com/color/96/checked--v1.png" alt="Qualidade">
      <h3>Qualidade</h3>
      <p>Produtos com alto padrão de qualidade para satisfazer nossos clientes.</p>
    </div>

    <div class="valor-card" data-aos="zoom-in" data-aos-delay="200">
      <img src="https://img.icons8.com/color/96/handshake--v1.png" alt="Compromisso">
      <h3>Compromisso</h3>
      <p>Atendimento ágil, transparente e comprometido com nossos parceiros.</p>
    </div>

    <div class="valor-card" data-aos="zoom-in" data-aos-delay="300">
      <img src="https://img.icons8.com/color/96/leaf.png" alt="Sustentabilidade">
      <h3>Sustentabilidade</h3>
      <p>Práticas que respeitam o meio ambiente e a comunidade local.</p>
    </div>

    <div class="valor-card" data-aos="zoom-in" data-aos-delay="400">
      <img src="https://img.icons8.com/color/96/idea.png" alt="Inovação">
      <h3>Inovação</h3>
      <p>Pesquisa constante para oferecer os melhores sabores e experiências.</p>
    </div>
  </div>
</section>


    <?php else: // SE NÃO ESTIVER LOGADO, MOSTRA ESTA MENSAGEM ?>

    <section class="login-necessario" style="text-align: center; padding: 40px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; margin: 30px 0;">
        <h2>Login Necessário</h2>
        <p>Você precisa estar logado em sua conta para enviar uma mensagem.</p>
        <a href="login_form.php" class="login-btn" style="display: inline-block; margin-top: 15px;">Ir para a página de Login</a>
    </section>

    <?php endif; ?>


    <section class="contato-info">
      <div class="info-item"><h3>Endereço</h3><p> convívio Santa Tereza - R. Bárbara do Amaral Campos, 40</p></div>
      <div class="info-item"><h3>Telefone</h3><p>(19) 99951-0173</p></div>
      <div class="info-item"><h3>Email</h3><p>contato@acaidasuica.com</p></div>
      <div class="info-item"><h3>Horário de Funcionamento</h3><p>Seg a Sex: 17H às 22h</p><p>Dom: 14h às 22h</p></div>
    </section>

    <section class="contato-mapa">
      <h2>Nos Encontre</h2>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.5749843614562!2d-47.69305532574842!3d-22.744033432072634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c637fa6843c5bf%3A0x78c6c3677d48448a!2zQcOnYWkgZGEgU3Vpw6dh!5e0!3m2!1spt-BR!2sbr!4v1751499566388!5m2!1spt-BR!2sbr" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>