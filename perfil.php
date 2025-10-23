<?php
session_start();

// Se o usuário não estiver logado, redireciona:
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: url('img/fundo1.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      color: #333;
      margin: 0;
      padding: 0;
    }

    main {
      max-width: 1200px;
      margin: 60px auto;
      padding: 40px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(111, 66, 193, 0.2);
      backdrop-filter: blur(10px);
      animation: fadeIn 0.6s ease-in-out;
    }

    h1, h2 {
      color: #6f42c1;
      font-weight: 700;
    }

    .perfil-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .perfil-header h1 {
      font-size: 2.2rem;
      background: linear-gradient(90deg, #6f42c1, #b678dd);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

      /* Remove o gradiente do emoji */
.emoji {
  -webkit-text-fill-color: initial; /* volta à cor padrão do sistema */
  background: none;
  }

    .perfil-header p {
      color: #333;
      font-size: 1.1rem;
    }

    .perfil-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-top: 20px;
    }

    .card-item {
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      text-align: center;
      transition: 0.3s;
    }

    .card-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(111,66,193,0.25);
    }

    .card-item i {
      font-size: 2.5rem;
      color: #6f42c1;
      margin-bottom: 15px;
    }

    .card-item h3 {
      font-size: 1.4rem;
      color: #6f42c1;
      margin-bottom: 10px;
    }

    .card-item p {
      color: #555;
      font-size: 0.95rem;
      margin-bottom: 20px;
    }

    .card-item a {
      display: inline-block;
      padding: 10px 20px;
      background: linear-gradient(90deg, #6f42c1, #b678dd);
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .card-item a:hover {
      transform: scale(1.05);
      background: linear-gradient(90deg, #b678dd, #6f42c1);
    }

    .admin-button {
      display: inline-block;
      margin: 25px 0;
      padding: 12px 25px;
      background: linear-gradient(90deg, #0d6efd, #0b5ed7);
      color: white;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: 0.3s;
    }

    .admin-button:hover {
      transform: scale(1.05);
      color: #fff;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      main {
        padding: 25px;
      }
      .perfil-header h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>

  <header class="text-center py-3 bg-white shadow-sm">
    <img src="Img/logo2.jpeg" alt="Açaí da Suíça" style="width: 90px; border-radius: 50%;">
    <h2 class="mt-2" style="color:#6f42c1;">Açaí da Suíça</h2>
    <a href="logout.php" class="btn btn-outline-danger btn-sm mt-2">Sair</a>
    <a href="index.php" class="btn btn-outline-danger btn-sm mt-2">Inicio</a>
  </header>

  <main>
    <div class="perfil-header">
      <h1>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?> <span class="emoji">👋</span></h1>
      <p>Gerencie suas informações e pedidos abaixo.</p>
    </div>

    <?php
    if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin') {
      echo '<div class="text-center"><a href="painel_admin.php" class="admin-button"><i class="fa-solid fa-user-shield"></i> Painel de Administrador</a></div>';
    }
    ?>

    <div class="perfil-cards">
      <div class="card-item">
        <i class="fa-solid fa-user"></i>
        <h3>Meus Dados</h3>
        <p>Atualize seu nome, e-mail e senha de acesso.</p>
        <a href="editar_perfil.php">Editar Dados</a>
      </div>


      <div class="card-item">
        <i class="fa-solid fa-receipt"></i>
        <h3>Últimos Pedidos</h3>
        <p>Veja os detalhes dos seus últimos pedidos.</p>
        <a href="meus_pedidos.php">Ver Pedidos</a>
      </div>

      <div class="card-item">
        <i class="fa-solid fa-headset"></i>
        <h3>Suporte</h3>
        <p>Entre em contato com nosso time de atendimento.</p>
        <a href="contato.php">Falar com Suporte</a>
      </div>
    </div>
  </main>

  <footer class="text-center py-4 bg-white mt-5 shadow-sm">
    <p class="m-0" style="color:#6f42c1;">© 2025 Açaí da Suíça | Todos os direitos reservados.</p>
  </footer>

</body>
</html>
