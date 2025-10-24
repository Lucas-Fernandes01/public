<?php
session_start();
include 'conexao.php';

// Proteção: se não estiver logado, não faz nada.
if (!isset($_SESSION['id'])) {
    header('Location: login_form.php');
    exit();
}

$id_usuario = $_SESSION['id'];
$action = $_REQUEST['action'] ?? null; // Pega 'action' tanto de POST quanto de GET

try {
    // --- LÓGICA PARA ATUALIZAR E-MAIL ---
    if ($action === 'update_email' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $novo_email = trim($_POST['email']);
        
        if (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Formato de e-mail inválido.");
        }

        $stmt = $conn->prepare("SELECT id FROM cadastro_usuarios WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $novo_email, $id_usuario);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Este e-mail já está em uso por outra conta.");
        }
        $stmt->close();

        $stmt = $conn->prepare("UPDATE cadastro_usuarios SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $novo_email, $id_usuario);
        $stmt->execute();
        $stmt->close();

        $_SESSION['email'] = $novo_email;
        $_SESSION['mensagem_sucesso'] = "E-mail atualizado com sucesso!";
    }

    // --- LÓGICA PARA ATUALIZAR SENHA ---
    elseif ($action === 'update_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $senha_atual = $_POST['senha_atual'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        if (empty($senha_atual) || empty($nova_senha) || empty($confirma_senha)) {
            throw new Exception("Todos os campos de senha são obrigatórios.");
        }
        if ($nova_senha !== $confirma_senha) {
            throw new Exception("A nova senha e a confirmação não correspondem.");
        }

        $stmt = $conn->prepare("SELECT senha FROM cadastro_usuarios WHERE id = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if (!$resultado || !password_verify($senha_atual, $resultado['senha'])) {
            throw new Exception("A senha atual está incorreta.");
        }
        if (password_verify($nova_senha, $resultado['senha'])) {
            throw new Exception("A nova senha não pode ser igual à senha atual.");
        }

        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE cadastro_usuarios SET senha = ? WHERE id = ?");
        $stmt->bind_param("si", $nova_senha_hash, $id_usuario);
        $stmt->execute();
        $stmt->close();

        $_SESSION['mensagem_sucesso'] = "Senha atualizada com sucesso!";
    }

    // --- LÓGICA PARA ADICIONAR ENDEREÇO ---
    elseif ($action === 'add_address' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM enderecos WHERE usuario_id = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'];
        $stmt->close();

        if ($total >= 5) {
            throw new Exception("Você já atingiu o limite de 5 endereços.");
        }

        $cep = trim($_POST['cep']);
        $bairro = trim($_POST['bairro']);
        $endereco = trim($_POST['endereco']);
        $numero = trim($_POST['numero']);
        $referencia = trim($_POST['referencia']);

        if (empty($cep) || empty($bairro) || empty($endereco) || empty($numero)) {
            throw new Exception("Todos os campos de endereço (exceto referência) são obrigatórios.");
        }

        $stmt = $conn->prepare("INSERT INTO enderecos (usuario_id, cep, bairro, endereco, numero, referencia) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id_usuario, $cep, $bairro, $endereco, $numero, $referencia);
        $stmt->execute();
        $stmt->close();

        $_SESSION['mensagem_sucesso'] = "Endereço adicionado com sucesso!";
    }
    
    // --- LÓGICA PARA EDITAR ENDEREÇO ---
    elseif ($action === 'edit_address' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $endereco_id = $_POST['endereco_id'];
        $cep = trim($_POST['cep']);
        $bairro = trim($_POST['bairro']);
        $endereco = trim($_POST['endereco']);
        $numero = trim($_POST['numero']);
        $referencia = trim($_POST['referencia']);

        if (empty($endereco_id) || empty($cep) || empty($bairro) || empty($endereco) || empty($numero)) {
            throw new Exception("Todos os campos de endereço (exceto referência) são obrigatórios.");
        }

        $stmt = $conn->prepare("UPDATE enderecos SET cep = ?, bairro = ?, endereco = ?, numero = ?, referencia = ? WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("sssssii", $cep, $bairro, $endereco, $numero, $referencia, $endereco_id, $id_usuario);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['mensagem_sucesso'] = "Endereço atualizado com sucesso!";
    }
    
    // --- LÓGICA PARA DELETAR ENDEREÇO ---
    elseif ($action === 'delete_address' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $endereco_id = $_GET['id'];
        
        if (empty($endereco_id)) {
            throw new Exception("ID do endereço não fornecido.");
        }
        
        $stmt = $conn->prepare("DELETE FROM enderecos WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $endereco_id, $id_usuario);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['mensagem_sucesso'] = "Endereço excluído com sucesso!";
    }

} catch (Exception $e) {
    $_SESSION['mensagem_erro'] = $e->getMessage();
}

$conn->close();
header('Location: editar_perfil.php');
exit();
?>