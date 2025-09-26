<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = trim($_POST["nome"] ?? '');
    $sobrenome = trim($_POST["sobrenome"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $senha = trim($_POST["senha"] ?? '');
    $bairro = trim($_POST["bairro"] ?? '');
    $endereco = trim($_POST["endereco"] ?? '');
    $numero = trim($_POST["numero"] ?? '');
    $referencia = trim($_POST["referencia"] ?? '');

    if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = 'Preencha todos os campos obrigatórios.';
        header('Location: login_form.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem_erro'] = 'O formato do e-mail é inválido.';
        header('Location: login_form.php');
        exit;
    }
    
    $sql_check_email = "SELECT id FROM cadastro_usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['mensagem_erro'] = 'Este e-mail já está cadastrado. Tente fazer login.';
        header('Location: login_form.php');
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    $nome_completo = $nome . ' ' . $sobrenome;

    $sql_insert = "INSERT INTO cadastro_usuarios (nome, email, senha, bairro, endereco, numero, referencia) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $nome_completo, $email, $senha_hash, $bairro, $endereco, $numero, $referencia);

    if ($stmt_insert->execute()) {
        $_SESSION['mensagem_sucesso'] = 'Cadastro realizado com sucesso! Faça seu login.';
        header('Location: login_form.php');
    } else {
        $_SESSION['mensagem_erro'] = 'Ocorreu um erro ao realizar o cadastro. Tente novamente.';
        header('Location: login_form.php');
    }

    $stmt_insert->close();
    $conn->close();
    exit;
}
?>