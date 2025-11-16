<?php
// Inicia a sessão para verificar quem está logado
session_start();

// 1. Verifica se o usuário está logado E se ele é um admin.
//    O @ ignora erros caso a sessão não exista, evitando avisos desnecessários.
if (!isset($_SESSION['id']) || @$_SESSION['tipo_usuario'] !== 'admin') {
    // 2. Se não for admin, destrói a sessão por segurança e redireciona para o login.
    session_destroy();
    header('Location: login_form.php');
    exit();
}

// Se o script continuar, significa que o usuário é um admin validado.
?>