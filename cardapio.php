<?php

session_start(); 
include 'conexao.php';


$sql = "SELECT nome, preco, tipo FROM ingredientes WHERE em_estoque = TRUE ORDER BY nome ASC";
$resultado = $conn->query($sql);


$tamanhos_copo = [];
$tamanhos_marmita = [];
$complementos = [];
$adicionais = [];

while ($item = $resultado->fetch_assoc()) {
    switch ($item['tipo']) {
        case 'tamanho_copo':
            $tamanhos_copo[] = $item;
            break;
        case 'tamanho_marmita':
            $tamanhos_marmita[] = $item;
            break;
        case 'complemento_gratis':
            $complementos[] = $item;
            break;
        case 'adicional_pago':
            $adicionais[] = $item;
            break;
    }
}

// --- NOVO CÓDIGO COMEÇA AQUI ---
// 4. BUSCAMOS OS ENDEREÇOS DO USUÁRIO LOGADO
$enderecos = [];
if (isset($_SESSION['id'])) {
    $usuario_id = $_SESSION['id'];
    
    
    $stmt = $conn->prepare("SELECT id, endereco, numero, bairro, cep FROM enderecos WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado_enderecos = $stmt->get_result();
    
    while ($endereco = $resultado_enderecos->fetch_assoc()) {
        $enderecos[] = $endereco;
    }
    $stmt->close();
}


$conn->close();
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
      <a href="quem_somos.php">Quem Somos</a>
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
    <h2>Monte seu pedido</h2>

    <label for="tipoPedido">Selecione o tipo:</label>
    <select id="tipoPedido" onchange="toggleTipo()">
      <option value="">-- Escolha --</option>
      <option value="copo">Copo</option>
      <option value="marmita">Marmita</option>
    </select>

    <div id="copoSection" style="display:none;">
      <h3>Escolha o tamanho (Copo):</h3>
      <div class="tamanho-opcoes">
    <?php foreach ($tamanhos_copo as $tamanho): ?>
        <?php $tamanho_id = 'tamanho-copo-' . str_replace([' ', '(', ')', '-'], '', strtolower($tamanho['nome'])); ?>
        <input type="radio" id="<?php echo $tamanho_id; ?>" name="tamanho" value="<?php echo htmlspecialchars($tamanho['nome']); ?> (Copo)" data-price="<?php echo $tamanho['preco']; ?>">
        <label for="<?php echo $tamanho_id; ?>">
            <?php echo htmlspecialchars($tamanho['nome']); ?>  

            R$ <?php echo number_format($tamanho['preco'], 2, ',', '.'); ?>
        </label>
    <?php endforeach; ?>
</div>
      <br>
      <h4>Escolha até 4 complementos grátis:</h4>
      <div class="complementos-gratis-copo">
        <?php foreach ($complementos as $item): ?>
            <div class="complemento-card" data-nome="<?php echo htmlspecialchars($item['nome']); ?>" data-preco="0.00">
                <div class="complemento-card-content">
                    <img src="img/complementos/<?php echo urlencode($item['nome']); ?>.png" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                    <h4><?php echo htmlspecialchars($item['nome']); ?></h4>
                    <p>Grátis</p>
                </div>
                <button class="btn-adicionar" type="button" onclick="adicionarComplemento('<?php echo htmlspecialchars($item['nome']); ?>', 0.00, 'complemento_gratis')">+</button>
            </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div id="marmitaSection" style="display:none;">
      <h3>Escolha o tamanho (Marmita):</h3>
      <div class="tamanho-opcoes">
    <?php foreach ($tamanhos_marmita as $tamanho): ?>
        <?php $tamanho_id = 'tamanho-marmita-' . str_replace([' ', '(', ')', '-'], '', strtolower($tamanho['nome'])); ?>
        <input type="radio" id="<?php echo $tamanho_id; ?>" name="tamanho" value="<?php echo htmlspecialchars($tamanho['nome']); ?> (Marmita)" data-price="<?php echo $tamanho['preco']; ?>">
        <label for="<?php echo $tamanho_id; ?>">
            <?php echo htmlspecialchars($tamanho['nome']); ?>  

            R$ <?php echo number_format($tamanho['preco'], 2, ',', '.'); ?>
        </label>
    <?php endforeach; ?>
</div>

      <br>
      <h4>Escolha até 5 complementos grátis:</h4>
      <div class="complementos-gratis-marmita">
        <?php foreach ($complementos as $item): ?>
            <div class="complemento-card" data-nome="<?php echo htmlspecialchars($item['nome']); ?>" data-preco="0.00">
                <div class="complemento-card-content">
                    <img src="img/complementos/<?php echo urlencode($item['nome']); ?>.png" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                    <h4><?php echo htmlspecialchars($item['nome']); ?></h4>
                    <p>Grátis</p>
                </div>
                <button class="btn-adicionar" type="button" onclick="adicionarComplemento('<?php echo htmlspecialchars($item['nome']); ?>', 0.00, 'complemento_gratis')">+</button>
            </div>
        <?php endforeach; ?>
      </div>
    </div>

    <h3>Adicionais pagos:</h3>
    <div class="adicionais">
        <?php foreach ($adicionais as $item): ?>
            <div class="complemento-card" data-nome="<?php echo htmlspecialchars($item['nome']); ?>" data-preco="<?php echo $item['preco']; ?>">
                <div class="complemento-card-content">
                    <img src="img/complementos/<?php echo urlencode($item['nome']); ?>.png" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                    <h4><?php echo htmlspecialchars($item['nome']); ?></h4>
                    <p>+ R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                </div>
                <button class="btn-adicionar" type="button" onclick="adicionarComplemento('<?php echo htmlspecialchars($item['nome']); ?>', <?php echo $item['preco']; ?>, 'adicional_pago')">+</button>
            </div>
        <?php endforeach; ?>
    </div><br>

          <h3>Tipo de entrega:</h3>
          <select name="entrega" id="tipoEntrega" onchange="toggleEntrega()" required>
            <option value="Retirar no local">Retirar no local</option>
            <option value="Delivery">Delivery</option>
          </select><br><br>

          <div id="enderecoSection" style="display:none;">
            <?php if (isset($_SESSION['id'])): // Verifica se o usuário está logado ?>
                
                <?php if (!empty($enderecos)): // Verifica se ele tem endereços cadastrados ?>
                    <h4>Escolha o endereço de entrega:</h4>
                    <?php foreach ($enderecos as $endereco): ?>
                        <label>
                            <input type="radio" name="endereco_id" value="<?php echo $endereco['id']; ?>" data-cep="<?php echo htmlspecialchars($endereco['cep']); ?>" required>
                            <?php 
                                echo htmlspecialchars($endereco['endereco']) . ', ' . htmlspecialchars($endereco['numero']) . ' - ' . htmlspecialchars($endereco['bairro']);
                            ?>
                        </label><br>
                    <?php endforeach; ?>
                    <br>
                    <a href="editar_perfil.php">Gerenciar ou adicionar novo endereço</a>

                <?php else: // Se não tiver endereços ?>
                    <p style="color: red; font-weight: bold;">Você não possui um endereço de entrega cadastrado.</p>
                    <p><a href="perfil.php">Clique aqui para adicionar um endereço</a> em seu perfil antes de finalizar o pedido.</p>
                <?php endif; ?>

            <?php else: // Se o usuário não estiver logado ?>
                <p style="color: red; font-weight: bold;">Você precisa <a href="login_form.php">fazer login</a> para selecionar a entrega em domicílio.</p>
            <?php endif; ?>
          </div>
          <label for="observacao">Observações:</label><br>
          <textarea name="observacao" rows="3" placeholder="Ex: Sem açúcar, mais gelado..."></textarea><br><br>

          <h3>Resumo do pedido:</h3><br>
          <div id="carrinho"></div>
          
          <h3>Total do pedido: R$ <span id="valorTotal">0.00</span></h3>
          <h3>Total a pagar: R$ <span id="valorTotalPagar">0.00</span></h3>

    <button type="button" onclick="finalizarPedidos()">Finalizar Pedido</button>
    <button type="button" onclick="adicionarPedido()">Adicionar Pedido</button>

  </main>

  <footer class="footer-dark">
      <div class="container py-5">
        <div class="row">
    
          <div class="col-md-3">
            <h5>Açaí da Suíça</h5>
            <p>Mais que sabor, uma experiência. Feito com carinho para conquistar você do seu jeito.</p>
            <a href="quem_somos.php" class="read-more">saiba mais → </a>
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

    <script>
        function toggleEntrega() {
            const tipoEntregaSelect = document.getElementById('tipoEntrega');
            const enderecoSectionDiv = document.getElementById('enderecoSection');

            // Se o valor selecionado for 'Delivery', mostra a seção de endereços.
            // Caso contrário, esconde.
            if (tipoEntregaSelect.value === 'Delivery') {
                enderecoSectionDiv.style.display = 'block';
            } else {
                enderecoSectionDiv.style.display = 'none';
            }
        }

        // Adiciona um listener para garantir que a função seja chamada assim que a página carregar.
        // Isso é útil caso a página seja recarregada e a opção "Delivery" já esteja selecionada.
        document.addEventListener('DOMContentLoaded', function() {
            toggleEntrega(); 
        });
    </script>
    </body>
</html>