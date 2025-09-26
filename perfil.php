<?php
session_start();

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
    </head>
<body>

    <h1>Bem-vindo(a) de volta, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>

    <p>Esta é a sua página de perfil.</p>
    
    <a href="logout.php">Sair</a>

</body>
</html>