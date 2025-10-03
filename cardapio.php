<?php
// Apenas iniciamos a sessão para verificar o status de login mais tarde
session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Monte seu Açaí - Açaí da Suíça</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <script>
      // Esta variável JavaScript nos dirá se o usuário está logado ou não.
      const isLoggedIn = <?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>;
    </script>
    <!-- script principal separado -->
    <script src="Js/script.js" defer></script>
    <link rel="stylesheet" href="css/cardapio.css">
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
      <a href="cardapio.php" class="active">Cardápio</a>
      <a href="quem-somos.html">Quem Somos</a>
      <a href="contato.html">Contato</a>
    </div>
  </nav>
  </header>
  
  <main>
    <h2>Monte seu pedido</h2>

    <label for="tipoPedido">Selecione o tipo:</label>
    <select id="tipoPedido" onchange="toggleTipo()">
      <option value="">-- Escolha --</option>
      <option value="copo">Copo</option>
      <option value="marmita">Marmita</option>
    </select>

    <div id="copoSection" style="display:none;">
      <h3>Escolha o tamanho (Copo):</h3>
      <label><input type="radio" name="tamanho" value="Copo 300ml - R$ 15,00" data-price="15.00"> 300 ml - R$ 15,00</label><br>
      <label><input type="radio" name="tamanho" value="Copo 400ml - R$ 18,00" data-price="18.00"> 400 ml - R$ 18,00</label><br>
      <label><input type="radio" name="tamanho" value="Copo 500ml - R$ 21,00" data-price="21.00"> 500 ml - R$ 21,00</label><br><br>

      <h4>Escolha até 4 complementos grátis:</h4>
      <div class="complementos-gratis-copo">
        <label><input type="checkbox" name="complementos" value="Paçoca"> Paçoca</label><br>
        <label><input type="checkbox" name="complementos" value="Leite em pó"> Leite em pó</label><br>
        <label><input type="checkbox" name="complementos" value="Confete"> Confete</label><br>
        <label><input type="checkbox" name="complementos" value="Granola"> Granola</label><br>
        <label><input type="checkbox" name="complementos" value="Granulado"> Granulado</label><br>
        <label><input type="checkbox" name="complementos" value="Banana"> Banana</label><br>
        <label><input type="checkbox" name="complementos" value="Chocoball"> Chocoball</label><br>
        <label><input type="checkbox" name="complementos" value="Gotas de chocolate"> Gotas de chocolate</label><br>
        <label><input type="checkbox" name="complementos" value="Mel"> Mel</label><br>
        <label><input type="checkbox" name="complementos" value="Leite condensado"> Leite condensado</label><br>
        <label><input type="checkbox" name="complementos" value="Amendoim torrado"> Amendoim torrado</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de morango"> Cobertura de morango</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de chocolate"> Cobertura de chocolate</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de uva"> Cobertura de uva</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de caramelo"> Cobertura de caramelo</label><br>
      </div>
    </div>

    <div id="marmitaSection" style="display:none;">
      <h3>Escolha o tamanho (Marmita):</h3>
      <label><input type="radio" name="tamanho" value="500 ml - R$ 22,00" data-price="22.00"> 500 ml - R$ 22,00</label><br>
      <label><input type="radio" name="tamanho" value="770 ml - R$ 35,00" data-price="35.00"> 770 ml - R$ 35,00</label><br><br>

      <h4>Escolha até 5 complementos grátis:</h4>
      <div class="complementos-gratis-marmita">
        <label><input type="checkbox" name="complementos" value="Paçoca"> Paçoca</label><br>
        <label><input type="checkbox" name="complementos" value="Leite em pó"> Leite em pó</label><br>
        <label><input type="checkbox" name="complementos" value="Confete"> Confete</label><br>
        <label><input type="checkbox" name="complementos" value="Granola"> Granola</label><br>
        <label><input type="checkbox" name="complementos" value="Granulado"> Granulado</label><br>
        <label><input type="checkbox" name="complementos" value="Banana"> Banana</label><br>
        <label><input type="checkbox" name="complementos" value="Chocoball"> Chocoball</label><br>
        <label><input type="checkbox" name="complementos" value="Gotas de chocolate"> Gotas de chocolate</label><br>
        <label><input type="checkbox" name="complementos" value="Mel"> Mel</label><br>
        <label><input type="checkbox" name="complementos" value="Leite condensado"> Leite condensado</label><br>
        <label><input type="checkbox" name="complementos" value="Amendoim torrado"> Amendoim torrado</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de morango"> Cobertura de morango</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de chocolate"> Cobertura de chocolate</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de uva"> Cobertura de uva</label><br>
        <label><input type="checkbox" name="complementos" value="Cobertura de caramelo"> Cobertura de caramelo</label><br>
      </div>
    </div>

    <h3>Adicionais pagos:</h3>
    <div class="adicionais">
      <label><input type="checkbox" name="adicionais" value="Bis - R$ 2,00" data-price="2.00"> Bis - R$ 2,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Ovomaltine - R$ 3,00" data-price="3.00"> Ovomaltine - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Sucrilhos - R$ 3,00" data-price="3.00"> Sucrilhos - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Morango - R$ 3,00" data-price="3.00"> Morango - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Uva - R$ 3,00" data-price="3.00"> Uva - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Manga - R$ 3,00" data-price="3.00"> Manga - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Creme de ninho - R$ 3,50" data-price="3.50"> Creme de ninho - R$ 3,50</label><br>
      <label><input type="checkbox" name="adicionais" value="Creme de avelã - R$ 3,00" data-price="3.00"> Creme de avelã - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Creme de morango - R$ 4,00" data-price="4.00"> Creme de morango - R$ 4,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Creme de amendoim - R$ 3,00" data-price="3.00"> Creme de amendoim - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Creme de bombom - R$ 3,00" data-price="3.00"> Creme de bombom - R$ 3,00</label><br>
      <label><input type="checkbox" name="adicionais" value="Jujuba - R$ 3,00" data-price="3.00"> Jujuba - R$ 3,00</label><br>
    </div><br>

          <h3>Tipo de entrega:</h3>
          <select name="entrega" required>
            <option value="Retirar no local">Retirar no local</option>
            <option value="Delivery">Delivery</option>
          </select><br><br>

          <label for="observacao">Observações:</label><br>
          <textarea name="observacao" rows="3" placeholder="Ex: Sem açúcar, mais gelado..."></textarea><br><br>

          <h3>Resumo do pedido:</h3><br>
          <div id="carrinho"></div>
          
        

          <h3>Total do pedido: R$ <span id="valorTotal">0.00</span></h3>
          <h3>Total a pagar: R$ <span id="valorTotalPagar">0.00</span></h3>

    <button type="button" onclick="finalizarPedidos()">Finalizar Pedido</button>
    <button type="button" onclick="adicionarPedido()">Adicionar Pedido</button>

    </form>
  </main>

  <footer class="footer-dark">
      <div class="container py-5">
        <div class="row">
    
          <div class="col-md-3">
            <h5>Açaí da Suíça</h5>
            <p>Mais que sabor, uma experiência. Feito com carinho para conquistar você do seu jeito.</p>
            <a href="#" class="read-more">saiba mais →</a>
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

</body>
</html>
