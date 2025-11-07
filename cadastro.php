<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Dados do usuário
    $nome = trim($_POST["nome"] ?? '');
    $sobrenome = trim($_POST["sobrenome"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $senha = trim($_POST["senha"] ?? '');

    // Dados do endereço
    $cep = trim($_POST["cep"] ?? '');
    $bairro = trim($_POST["bairro"] ?? '');
    $endereco = trim($_POST["endereco"] ?? '');
    $numero = trim($_POST["numero"] ?? '');
    $referencia = trim($_POST["referencia"] ?? '');

    // Validação
    if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($cep) || empty($bairro) || empty($endereco) || empty($numero)) {
        $_SESSION['mensagem_erro'] = 'Preencha todos os campos obrigatórios (nome, email, senha, cep, bairro, endereço e número).';
        header('Location: login_form.php');
        exit;
    }

    if (strlen($senha) < 6) {
        $_SESSION['mensagem_erro'] = 'A senha deve ter pelo menos 6 caracteres.';
        header('Location: login_form.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem_erro'] = 'O formato do e-mail é inválido.';
        header('Location: login_form.php');
        exit;
    }
    
    // 1. VERIFICAR SE O E-MAIL JÁ EXISTE
    $sql_check_email = "SELECT id FROM cadastro_usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['mensagem_erro'] = 'Este e-mail já está cadastrado. Tente fazer login.';
        $stmt_check->close();
        header('Location: login_form.php');
        exit;
    }
    $stmt_check->close();

    // Iniciar transação
    $conn->begin_transaction();

    try {
        // 2. INSERIR NA TABELA cadastro_usuarios
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $nome_completo = $nome . ' ' . $sobrenome;

        // Query atualizada: removemos os campos de endereço daqui
        $sql_insert_user = "INSERT INTO cadastro_usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, 'cliente')";
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bind_param("sss", $nome_completo, $email, $senha_hash);
        
        if (!$stmt_insert_user->execute()) {
            throw new Exception("Erro ao criar o usuário.");
        }
        
        // Pegar o ID do usuário que acabamos de criar
        $id_usuario_novo = $conn->insert_id;
        $stmt_insert_user->close();

        // 3. INSERIR NA TABELA enderecos
        $sql_insert_addr = "INSERT INTO enderecos (usuario_id, cep, bairro, endereco, numero, referencia) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_addr = $conn->prepare($sql_insert_addr);
        $stmt_insert_addr->bind_param("isssss", $id_usuario_novo, $cep, $bairro, $endereco, $numero, $referencia);
        
        if (!$stmt_insert_addr->execute()) {
            throw new Exception("Erro ao salvar o endereço.");
        }
        $stmt_insert_addr->close();
        
        // Se tudo deu certo, confirma as mudanças no banco
        $conn->commit();
        
        $_SESSION['mensagem_sucesso'] = 'Cadastro realizado com sucesso! Faça seu login.';
        header('Location: login_form.php');

    } catch (Exception $e) {
        // Se algo deu errado, desfaz tudo
        $conn->rollback();
        $_SESSION['mensagem_erro'] = 'Ocorreu um erro: ' . $e->getMessage() . ' Tente novamente.';
        header('Location: login_form.php');
    }

    $conn->close();
    exit;
}
?>