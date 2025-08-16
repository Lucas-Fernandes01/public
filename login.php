<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($senha, $usuario["senha"])) {
            $_SESSION["id_usuario"] = $usuario["id"];
            $_SESSION["nome"] = $usuario["nome"];
            $_SESSION["endereco"] = $usuario["endereco"] ?? '';
            $_SESSION["foto"] = $usuario["foto"] ?? '';

            header("Location: index.html");
            exit;
        } else {
            echo "<script>alert('Senha incorreta!');window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado!');window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
