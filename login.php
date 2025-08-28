<?php
// Inicia a sessão do PHP, permitindo usar variáveis de sessão ($_SESSION)
session_start();

// Inclui o arquivo de conexão com o banco de dados
include "conexao.php";

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os valores enviados pelo formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Prepara a consulta SQL para buscar o usuário pelo e-mail
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql); // Prepara a query para execução segura
    $stmt->bind_param("s", $email); // Liga o parâmetro $email à query (tipo string)
    $stmt->execute(); // Executa a query
    $resultado = $stmt->get_result(); // Obtém o resultado da consulta

    // Verifica se algum usuário foi encontrado
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc(); // Converte o resultado em array associativo

        // Verifica se a senha fornecida confere com a senha armazenada (hash)
        if (password_verify($senha, $usuario["senha"])) {
            // Cria variáveis de sessão com os dados do usuário
            $_SESSION["id_usuario"] = $usuario["id"];
            $_SESSION["nome"] = $usuario["nome"];
            $_SESSION["endereco"] = $usuario["endereco"] ?? ''; // Se não tiver endereço, usa string vazia
            $_SESSION["foto"] = $usuario["foto"] ?? ''; // Se não tiver foto, usa string vazia

            // Redireciona para a página inicial
            header("Location: index.html");
            exit; // Garante que o script pare após o redirecionamento
        } else {
            // Senha incorreta: mostra alerta e volta para a página anterior
            echo "<script>alert('Senha incorreta!');window.history.back();</script>";
        }
    } else {
        // Usuário não encontrado: mostra alerta e volta para a página anterior
        echo "<script>alert('Usuário não encontrado!');window.history.back();</script>";
    }

    // Fecha a consulta preparada
    $stmt->close();
    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
