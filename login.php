<?php
session_start();
include 'conexao.php';

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: login_form.php');
    exit();
}

$email = trim($_POST['email']);
$senhaDigitada = $_POST['senha'];

// 1. ATUALIZAMOS A CONSULTA SQL para buscar o novo campo 'tipo_usuario'
$stmt = $conn->prepare('SELECT id, nome, email, senha, tipo_usuario FROM cadastro_usuarios WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows === 1) {
    $usuario = $res->fetch_assoc();

    if (password_verify($senhaDigitada, $usuario['senha'])) {
        // Previne session fixation
        session_regenerate_id(true);

        // 2. SALVAMOS TODOS OS DADOS IMPORTANTES NA SESSÃO
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario']; // O novo campo é salvo aqui!

        $stmt->close();
        $conn->close();

        // 3. LÓGICA DE REDIRECIONAMENTO INTELIGENTE
        
        // Se o usuário for um 'admin', ele vai direto para o painel de admin.
        if ($_SESSION['tipo_usuario'] === 'admin') {
            header('Location: painel_admin.php'); // Redireciona para a futura página do painel
            exit();
        }

        // Se for um cliente, usamos a lógica de redirecionamento que já existia.
        $redirect_url = $_POST['redirect_url'] ?? '';
        
        if (!empty($redirect_url)) {
            header('Location: ' . $redirect_url);
        } else {
            header('Location: index.php');
        }
        exit();

    } else {
        // Senha incorreta
        $_SESSION['nao_autenticado'] = true;
        header('Location: login_form.php');
        exit();
    }
} else {
    // Usuário não encontrado
    $_SESSION['nao_autenticado'] = true;
    header('Location: login_form.php');
    exit();
}

?>