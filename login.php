<?php
session_start();
include ('conexao.php');

if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

if(empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: login.html');
    exit();
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['senha']);

$query = "SELECT id, nome, email FROM cadastro_usuarios WHERE email = '{$email}' and senha = md5('{$pass}')";

$result = mysqli_query($conn, $query);

$row = mysqli_num_rows($result);

if($row == 1) {
    $usuario = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['email'] = $usuario['email'];
    header('Location: index.php');
    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: login_form.php');
    exit();
}
