<?php
session_start();

// 1. VERIFICA SE O USUÁRIO ESTÁ LOGADO ANTES DE TUDO
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    // Se não estiver logado, cria uma mensagem de erro e volta para a página de contato
    $_SESSION['mensagem_contato'] = "Erro: Você precisa estar logado para enviar uma mensagem.";
    $_SESSION['mensagem_contato_tipo'] = "erro";
    header("Location: contato.php");
    exit();
}

// 2. VERIFICA SE O MÉTODO DE REQUISIÇÃO É POST (se o formulário foi enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. COLETA E LIMPA OS DADOS
    $email_destinatario = "contato@acaidasuica.com";        // SEU E-MAIL FIXO AQUI
    $email_remetente = $_SESSION['email'];                  // E-mail do usuário logado
    $nome_remetente = $_SESSION['nome'];                    // Nome do usuário logado
    $assunto_email = trim(htmlspecialchars($_POST["assunto"]));
    $mensagem_corpo = trim(htmlspecialchars($_POST["mensagem"]));

    // 4. VALIDAÇÃO DOS CAMPOS OBRIGATÓRIOS
    if (empty($assunto_email) || empty($mensagem_corpo)) {
        $_SESSION['mensagem_contato'] = "Erro: Assunto e mensagem são obrigatórios.";
        $_SESSION['mensagem_contato_tipo'] = "erro";
        header("Location: contato.php");
        exit();
    }
    
    // 5. PROCESSA O ANEXO (SE EXISTIR)
    $tem_anexo = isset($_FILES['anexo']) && $_FILES['anexo']['error'] == UPLOAD_ERR_OK;
    $boundary = "----=" . md5(uniqid(time())); // Delimitador para o e-mail

    // 6. MONTA OS CABEÇALHOS (HEADERS) DO E-MAIL
    // O 'From' usa o e-mail do seu servidor, mas o 'Reply-To' usa o e-mail do usuário.
    // Isso aumenta a chance do e-mail não ser marcado como SPAM.
    $headers = "From: contato@acaidasuica.com\r\n"; // Um e-mail do seu próprio domínio
    $headers .= "Reply-To: " . $email_remetente . "\r\n"; // ESSENCIAL: Para você responder para o cliente
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";
    
    // 7. MONTA O CORPO DO E-MAIL
    $corpo = "--" . $boundary . "\r\n";
    $corpo .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $corpo .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $corpo .= "Nova mensagem do site 'Açaí da Suíça':\n\n";
    $corpo .= "Enviado por: " . $nome_remetente . " (" . $email_remetente . ")\n";
    $corpo .= "Assunto: " . $assunto_email . "\n\n";
    $corpo .= "Mensagem:\n" . $mensagem_corpo . "\r\n\r\n";

    if ($tem_anexo) {
        $caminho_arquivo = $_FILES['anexo']['tmp_name'];
        $nome_arquivo = $_FILES['anexo']['name'];
        $tipo_arquivo = $_FILES['anexo']['type'];
        $anexo_conteudo = chunk_split(base64_encode(file_get_contents($caminho_arquivo)));

        $corpo .= "--" . $boundary . "\r\n";
        $corpo .= "Content-Type: " . $tipo_arquivo . "; name=\"" . $nome_arquivo . "\"\r\n";
        $corpo .= "Content-Transfer-Encoding: base64\r\n";
        $corpo .= "Content-Disposition: attachment; filename=\"" . $nome_arquivo . "\"\r\n\r\n";
        $corpo .= $anexo_conteudo . "\r\n";
    }

    $corpo .= "--" . $boundary . "--\r\n";

    // 8. TENTA ENVIAR O E-MAIL E REDIRECIONA
    if (mail($email_destinatario, $assunto_email, $corpo, $headers)) {
        $_SESSION['mensagem_contato'] = "Mensagem enviada com sucesso! Agradecemos o contato.";
        $_SESSION['mensagem_contato_tipo'] = "sucesso";
    } else {
        // Lembrete: Isso provavelmente falhará no XAMPP local.
        $_SESSION['mensagem_contato'] = "Desculpe, ocorreu uma falha técnica ao enviar sua mensagem. Tente novamente mais tarde.";
        $_SESSION['mensagem_contato_tipo'] = "erro";
    }

    header("Location: contato.php");
    exit();

} else {
    // Acesso direto ao arquivo não é permitido
    echo "Acesso inválido.";
}
?>