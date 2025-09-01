<?php
session_start();
include 'conexao.php';

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: login_form.php');
    exit();
}

$email = trim($_POST['email']);
$senhaDigitada = $_POST['senha'];

// Prepared statement para evitar injeção
$stmt = $conn->prepare('SELECT id, nome, email, senha FROM cadastro_usuarios WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows === 1) {
    $usuario = $res->fetch_assoc();

    if (password_verify($senhaDigitada, $usuario['senha'])) {
        // previne session fixation
        session_regenerate_id(true);

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];

        $stmt->close();
        $conn->close();

        header('Location: index.php');
        exit();
    } else {
        $_SESSION['nao_autenticado'] = true;
        $stmt->close();
        $conn->close();
        header('Location: login_form.php');
        exit();
    }
} else {
    $_SESSION['nao_autenticado'] = true;
    $stmt->close();
    $conn->close();
    header('Location: login_form.php');
    exit();
}
