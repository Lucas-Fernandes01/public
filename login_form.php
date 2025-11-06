<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Açaí da Suíça</title>
  <link rel="stylesheet" href="Css/login.css" />
  <link rel="stylesheet" href="Css/style.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-HJ9mI+qV...sUA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <script src="Js/script.js"></script>
  <script src="Js/auth.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
</head>
<body>




<main>
    <?php
    // Mensagem de erro para login (do seu código original)
    if(isset($_SESSION['nao_autenticado'])):
    ?>
    <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; text-align:center; padding:10px; font-weight:bold; margin: 10px auto; width: 80%;">
      Usuário ou senha inválidos.
    </div>
    <?php
    unset($_SESSION['nao_autenticado']);
    endif;

    // Mensagem de erro genérica (para cadastro, etc.)
    if(isset($_SESSION['mensagem_erro'])):
    ?>
    <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; text-align:center; padding:10px; font-weight:bold; margin: 10px auto; width: 80%;">
      <?php echo $_SESSION['mensagem_erro']; ?>
    </div>
    <?php
    unset($_SESSION['mensagem_erro']);
    endif;

    // Mensagem de sucesso para cadastro
    if(isset($_SESSION['mensagem_sucesso'])):
    ?>
    <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; text-align:center; padding:10px; font-weight:bold; margin: 10px auto; width: 80%;">
      <?php echo $_SESSION['mensagem_sucesso']; ?>
    </div>
    <?php
    unset($_SESSION['mensagem_sucesso']);
    endif;
    ?>
    <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
    <mask id="mask0" mask-type="alpha">
      <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
      0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
      591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
      167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
    </mask>
  
    <g mask="url(#mask0)">
      <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
      0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
      591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
      167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
  
      <image class="login__img" href="Img/bg-img.jpg"/>
    </g>
  </svg>      

  <div class="login container grid" id="loginAccessRegister">
    <div class="login__access">
      <h1 class="login__title">Acesse sua conta</h1>
      
      <div class="login__area">
        <form action="login.php" method="post" class="login__form">
          
          <?php
            $redirect_url = isset($_GET['redirect_url']) ? htmlspecialchars($_GET['redirect_url']) : '';
          ?>
          <input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>">

          <div class="login__content grid">
            <div class="login__box">
              <input type="email" id="login_email" name="email" required placeholder=" " class="login__input">
              <label for="login_email" class="login__label">Email</label>
              <i class="ri-mail-fill login__icon"></i>
            </div>
    
            <div class="login__box">
              <input type="password" id="login_senha" name="senha" required placeholder=" " class="login__input">
              <label for="login_senha" class="login__label">Senha</label>
              <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
            </div>
          </div>
    
          <a href="solicitar_reset.php" class="login__forgot">Esqueci minha senha</a>
    
          <button type="submit" class="login__button">Entrar</button>
        </form>
  
        <div class="login__social">
          <p class="login__social-title">Ou faça login com</p>
          <div class="login__social-links">
            <a onclick="loginWithGoogle()" class="login__social-link">
              <img src="Img/icon-google.svg" alt="image" class="login__social-img">
            </a>
            <a  onclick="loginWithFacebook()" class="login__social-link">
              <img src="Img/icon-facebook.svg" alt="image" class="login__social-img">
            </a>
            <a  onclick="loginWithApple()" class="login__social-link">
              <img src="Img/icon-apple.svg" alt="image" class="login__social-img">
            </a>
          </div>
        </div>
  
        <p class="login__switch">
          Ainda não tem uma conta?</br>
          <button type="button" id="loginButtonRegister">Criar Conta</button>
        </p>
      </div>
    </div>

    <div class="login__register">
      <h1 class="login__title">Criar nova conta</h1>

      <div class="login__area">
        <form action="cadastro.php" method="post" class="login__form">
          <div class="login__content grid">
            <div class="login__group grid">
              <div class="login__box">
                <input type="text" id="cadastro_nome" name="nome" required placeholder=" " class="login__input">
                <label for="cadastro_nome" class="login__label">Nome</label>
                <i class="ri-id-card-fill login__icon"></i>
              </div>
      
              <div class="login__box">
                <input type="text" id="cadastro_sobrenome" name="sobrenome" required placeholder=" " class="login__input">
                <label for="cadastro_sobrenome" class="login__label">Sobrenome</label>
                <i class="ri-id-card-fill login__icon"></i>
              </div>
            </div>

            <div class="login__box">
              <input type="email" id="cadastro_email" name="email" required placeholder=" " class="login__input">
              <label for="cadastro_email" class="login__label">Email</label>
              <i class="ri-mail-fill login__icon"></i>
            </div>
    
            <div class="login__box">
              <input type="password" id="cadastro_senha" name="senha" placeholder=" " class="login__input">
              <label for="cadastro_senha" class="login__label">Senha</label>
              <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordCreate"></i>
            </div>

            <div class="login__group grid">
              <div class="login__box">
                <input type="text" id="cadastro_bairro" name="bairro" required placeholder=" " class="login__input">
                <label for="cadastro_bairro" class="login__label">Bairro</label>
                <i class="ri-map-pin-2-fill login__icon"></i>
              </div>

              <div class="login__box">
                <input type="text" id="cadastro_endereco" name="endereco" required placeholder=" " class="login__input">
                <label for="cadastro_endereco" class="login__label">Endereço</label>
                <i class="ri-home-4-fill login__icon"></i>
              </div>
            </div>

            <div class="login__group grid">
              <div class="login__box">
                <input type="text" id="cadastro_numero" name="numero" required placeholder=" " class="login__input">
                <label for="cadastro_numero" class="login__label">Número</label>
                <i class="ri-numbers-line login__icon"></i>
              </div>

              <div class="login__box">
                <input type="text" id="cadastro_referencia" name="referencia" placeholder=" " class="login__input">
                <label for="cadastro_referencia" class="login__label">Complemento</label>
                <i class="ri-map-pin-line login__icon"></i>
              </div>
            </div>
          </div>

          <button type="submit" class="login__button">Criar conta</button>
        </form>
  
        <p class="login__switch">
          Já tem uma conta? </br>
          <button type="button" id="loginButtonAccess">Entrar</button>
        </p>
      </div>
    </div>
  </div>
      
  <script src="Js/main.js"></script>
</main>

<footer class="footer-dark">
  <div class="container py-5">
    <div class="row">

      <div class="col-md-3">
        <h5>Açaí da Suíça</h5>
        <p>Mais que sabor, uma experiência. Feito com carinho para conquistar você do seu jeito.</p>
        <a href="quem_somos.php" class="read-more">saiba mais →</a>
      </div>

      <div class="col-md-3">
        <h5>Contato</h5>
        <ul class="list-unstyled">
          <li><i class="fas fa-map-marker-alt"></i> Nova Suiça, Piracicaba - SP</li>
          <li><i class="fas fa-phone"></i> (19) 99951-0173</li>
          <li><i class="fas fa-envelope"></i> contato@acaidasuica.com.br</li>
        </ul>
      </div>

      <div class="col-md-3">
        <h5>Funcionamento</h5>
        <ul class="list-unstyled">
          <li>Seg a Sex: 17h - 22h</li>
          <li>Domingo: 14h - 22h</li>
        </ul>
      </div>

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
  
  <div class="footer-bottom text-center py-3">
    © 2025 Açaí da Suíça | Todos os direitos reservados.
  </div>
</footer>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<script src="https://www.gstatic.com/firebasejs/9.6.11/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.11/firebase-auth.js"></script>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCGOKepunCzj0teRCX_2fwcQEKKiKvDC-o",
    authDomain: "acaidasuica-1420a.firebaseapp.com",
    projectId: "acaidasuica-1420a",
    storageBucket: "acaidasuica-1420a.firebasestorage.app",
    messagingSenderId: "1040820539876",
    appId: "1:1040820539876:web:e03faa8721a39377aff7f1",
    measurementId: "G-F1JLCV5CWP"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  const auth = firebase.auth();
</script>

</body>
</html>