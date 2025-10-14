<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Açaí da Suíça</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
      <img src="img/Logo.jpg" alt="Açaí da Suíça Logo" class="logo"/>
      <div class="logo-text">
        <h1>Sabor que conquista</h1>
      </div>
    </div>


      <nav>
        <div class="nav-links">
          <a href="index.php" class="active">Início</a>
          <a href="cardapio.php">Cardápio</a>
          <a href="quem-somos.php">Quem Somos</a>
          <a href="contato.php">Contato</a>
        </div>

      <?php if (isset($_SESSION['id'])): ?>
        <a href="perfil.php" class="login-btn">Meu Perfil</a>
      <?php else: ?>
        <a href="login_form.php" class="login-btn">Fazer Login</a>
      <?php endif; ?>

      </nav>
      
    </header>

    <main>
      <div class="hero-image">
        <img src="Img/HEADER2.jpg" alt="Marmita Açaí da Suíça" />

        <div class="hero-buttons">
          <a href="contato.php" class="btn-primary">Entre em contato</a>
          <a href="cardapio.php" class="btn-secondary">Ver cardápio</a>
        </div>
      </div>

      <img src="Img/icon/grunge-divider-3.png" alt="" style="width:100%; display:block; margin-top: 0px;">

      <!--VALORES-->

      <section id="valores">
  <h2 style=" padding: 30px; text-align:center; color:#4B0055;" data-aos="fade-up">NOSSOS VALORES</h2>
  
  <div style=" display:flex; flex-wrap: nowrap; justify-content:space-around; max-width:1000px; margin:0 auto;">
  
    <div style="text-align:center; margin:20px;" data-aos="fade-right" data-aos-delay="100">
      <img src="https://img.icons8.com/color/96/000000/checked--v1.png" alt="Qualidade" style="width:60px;">
      <h3>Qualidade</h3>
      <p>Produtos com alto padrão de qualidade para satisfazer nossos clientes.</p>
    </div>
    
    <div style="text-align:center; margin:20px;" data-aos="fade-right" data-aos-delay="200">
      <img src="https://img.icons8.com/color/96/000000/handshake--v1.png" alt="Compromisso" style="width:60px;">
      <h3>Compromisso</h3>
      <p>Atendimento ágil, transparente e comprometido com nossos parceiros.</p>
    </div>
    
    <div style="text-align:center; margin:20px;" data-aos="fade-right" data-aos-delay="300">
      <img src="https://img.icons8.com/color/96/000000/leaf.png" alt="Sustentabilidade" style="width:60px;">
      <h3>Sustentabilidade</h3>
      <p>Práticas que respeitam o meio ambiente e a comunidade local.</p>
    </div>
    
    <div style="text-align:center; margin:20px;" data-aos="fade-right" data-aos-delay="400">
      <img src="https://img.icons8.com/color/96/000000/idea.png" alt="Inovação" style="width:60px;">
      <h3>Inovação</h3>
      <p>Pesquisa constante para oferecer os melhores sabores e experiências.</p>
    </div>
  
  </div>
</section>

<!-- QUEM SOMOS -->
<section class="quem-somos">
  <div class="quem-somos-container">
    <div class="quem-somos-texto">
      <h2>Quem é Açaí da Suíça?</h2>
      <p>
        O Açaí da Suíça nasceu em 27 de maio de 2023 com o propósito de levar sabor, qualidade e praticidade para o dia a dia de nossos clientes. Desde o início, nossa missão sempre foi oferecer produtos diferenciados, feitos com carinho e ingredientes selecionados.

        Nossa fundadora transformou uma paixão por empreender em um negócio dedicado a atender quem valoriza o verdadeiro sabor do açaí. Hoje, trabalhamos com diversas opções para todos os gostos, como açaí no copo, marmitas, sorvetes e fondue, sempre buscando inovar e atender às necessidades dos nossos clientes com qualidade e bom atendimento.
        
        Acreditamos que o açaí é mais que um alimento: é uma experiência que une sabor, energia e alegria. Por isso, seguimos crescendo e nos aperfeiçoando, mantendo nosso compromisso com quem nos escolhe todos os dias.
      </p>
    </div>
    <div class="quem-somos-imagem">
      <img src="Img/Logo.jpg" alt="Açaí da Suíça">
  
    </div>
  </div>
  
</section>

      

       <!-- DESTAQUES -->
  <section class="destaques">
    <div class="destaques-container">
      <h2>Cardápios</h2>
      <div class="destaques-cards">
        <div class="card" data-aos="zoom-in-up" data-aos-delay="100">
          <img src="Img/cardapio/copo.jpg" alt="Açaí no Copo">
          <h3>Açaí no Copo</h3>
          <p>Delicioso açaí servido no copo, perfeito para qualquer hora.</p>
        </div>
        <div class="card" data-aos="fade-up" data-aos-delay="200">
          <img src="Img/cardapio/marmita.jpg" alt="Açaí na Marmita">
          <h3>Açaí na Marmita</h3>
          <p>Praticidade e sabor em uma marmita recheada de açaí.</p>
        </div>
        <div class="card" data-aos="fade-up" data-aos-delay="300">
          <img src="Img/cardapio/combos.jpg" alt="Combos de Açaí">
          <h3>Combos de Açaí</h3>
          <p>Experimente nossos combos especiais com açaí.</p>
        </div>
        <div class="card" data-aos="fade-up" data-aos-delay="400">
          <img src="Img/cardapio/fondue.jpg" alt="Fondue de Açaí">
          <h3>Fondue de Açaí</h3>
          <p>Uma experiência única com nosso fondue de açaí.</p>
        </div>


    <h2>Combos Especiais</h2>
    <div class="cards">
      <div class="card" data-aos="zoom-in-up" data-aos-delay="100">
      
        <img src="Img/card/card1.jpg" alt="Combo 1">
        <h3>Combo Trufado</h3>
        <p>2 copos de 300ml com açai, leite condensado, leite em pó, creme de avelã e ovolmaltine</p>
      </div>
      <div class="card" data-aos="zoom-in-up" data-aos-delay="200">
        <img src="Img/card/card2.jpg" alt="Combo 2">
        <h3>Combo Familia</h3>
        <p>2 copos de 400ml e 1 copo de 300ml com açai, leite condensado, leite em pó e granola.</p>
      </div>
      <div class="card" data-aos="zoom-in-up" data-aos-delay="300">
        <img src="Img/card/card3.jpg" alt="Combo 3">
        <h3>Combo Ninho</h3>
        <p>2 copos de 300ml com açai, leite condensado, leite em pó, creme de ninho e confete.</p>
      </div>
      <div class="card" data-aos="zoom-in-up" data-aos-delay="400">
        <img src="Img/card/card4.jpg" alt="Combo 4">
        <h3>Combo Cruella</h3>
        <p>2 copo de 400ml com açai, creme de avelã, creme de ninho, chocoball, gotas de chocolate e leite em pó.</p>
      </div>
      <div class="card" data-aos="zoom-in-up" data-aos-delay="500">
        <img src="Img/card/card5.jpg" alt="Combo 5">
        <h3>Combo Bis</h3>
        <p>2 copos de 300ml com açai, leite condensado, leite em pó, bis e granola.</p>
      </div>
    </div>
  </section>

  
  <!-- Galeria de Fotos-->

 <section id="galeria-produtos" class="secao-padrao">
  <div class="container">
    <h2 class="titulo-secao">Nossos Produtos</h2>
    <p class="subtitulo-secao">Confira um pouco do nosso cardápio!</p>

    <div class="galeria-grid">
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes1.jpg" alt="Açaí no copo">
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes2.jpg" alt="Açaí na marmita">
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes3.jpg" alt="Sorvete">
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes4.jpg" alt="Fondue">
    
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes5.jpg" alt="Açaí com frutas">
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes6.jpg" alt="Açaí com granola">
    </div>
    <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes7.jpg" alt="Açaí com leite condensado">
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientes8.jpg" alt="Açaí com chocolate">
      </div>
      <div class="galeria-item">
        <img src="Img/clientes/feedback_clientesFondue.jpg" alt="Açaí com morango">
  </div>
    <div class="galeria-item">
        <img src="Img/clientes/feedback_clientesBOLO.jpg" alt="Açaí com leite em pó">
      </div>

</section>


<section class="feedbacks">
  <h2>O que dizem nossos clientes</h2>
  <div class="feedback-container">
    <div class="feedback-card">
      <p class="feedback-text"><img src="Img/feedback/feedback_1.jpg" alt="Feedback 1">“O melhor açaí que já provei! Atendimento excelente e entrega rápida.”</p>
      <p class="feedback-author">– João Silva</p>
    </div>
    <div class="feedback-card">
      <p class="feedback-text"><img src="Img/feedback/feedback_2.jpg" alt="Feedback 2">“Atendimento ótimo e açaí maravilhoso!”</p>
      <p class="feedback-author">– Maria Oliveira</p>
    </div>
    <div class="feedback-card">
      <p class="feedback-text"><img src="Img/feedback/feedback_3.jpg" alt="Feedback 3">“Virei cliente fiel! Entrega rápida e sabor incrível.”</p>
      <p class="feedback-author">– Lucas Pereira</p>
    </div>
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
    
    
</script>
  </body>
</html>
