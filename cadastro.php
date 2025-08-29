<?php
include "conexao.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $senha = $_POST["senha"] ?? '';
    $bairro = $_POST["bairro"] ?? '';
    $endereco = $_POST["endereco"] ?? '';
    $numero = $_POST["numero"] ?? '';
    $referencia = $_POST["referencia"] ?? '';

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos obrigatórios.'); history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email inválido.'); history.back();</script>";
        exit;
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir usuário
    $sql_usuario = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_usuario);
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        $id_usuario = $conn->insert_id;

        // Inserir endereço
        $sql_endereco = "INSERT INTO enderecos (id_usuario, bairro, endereco, numero, referencia)
                         VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql_endereco);
        $stmt2->bind_param("issss", $id_usuario, $bairro, $endereco, $numero, $referencia);
        $stmt2->execute();

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location='login_form.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
