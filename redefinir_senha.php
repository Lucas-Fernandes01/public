<?php
include 'conexao.php';

$token = $_GET['token'] ?? null;
$token_valido = false;
$email_usuario = null;
$erro = "";
$sucesso = "";

if ($token) {
    $sql = "SELECT * FROM password_resets WHERE token = ? AND usado = 0 AND expires_at > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $token_valido = true;
        $dados_token = $resultado->fetch_assoc();
        $email_usuario = $dados_token['email'];
    }
}

if ($token_valido && $_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($nova_senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem!";
    } else if (strlen($nova_senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $sql_update = "UPDATE cadastro_usuarios SET senha = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $senha_hash, $email_usuario);
        $stmt_update->execute();

        $sql_invalidate = "UPDATE password_resets SET usado = 1 WHERE token = ?";
        $stmt_invalidate = $conn->prepare($sql_invalidate);
        $stmt_invalidate->bind_param("s", $token);
        $stmt_invalidate->execute();

        $sucesso = "Senha redefinida com sucesso! Você já pode fazer o login.";
        $token_valido = false; 
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Açaí</title>
    
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <style>
        /*=============== GOOGLE FONTS ===============*/
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap");

        /*=============== VARIABLES CSS ===============*/
        :root {
            --first-color: hsl(266, 92%, 54%);
            --first-color-alt: hsl(271, 85%, 40%);
            --title-color: hsl(220, 68%, 4%);
            --white-color: hsl(0, 0%, 100%);
            --text-color: hsl(220, 15%, 66%);
            --body-color: hsl(0, 0%, 100%);
            --container-color: hsl(220, 50%, 97%);

            --body-font: "Montserrat", system-ui;
            --big-font-size: 1.5rem;
            --normal-font-size: .938rem;
            --small-font-size: .813rem;
            --tiny-font-size: .688rem;
            --font-semi-bold: 600;
        }

        /*=============== BASE ===============*/
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        body, input, button {
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
        }
        body {
            background-color: var(--body-color);
            color: var(--text-color);
        }
        input, button {
            border: none;
            outline: none;
        }
        a {
            text-decoration: none;
        }
        .grid {
            display: grid;
            gap: 1rem;
        }

        /*=============== LOGIN LAYOUT ===============*/
        .login {
            position: relative;
            height: 100vh;
            display: grid; /* Alterado para grid */
            align-items: center;
            overflow: hidden;
        }
        .login__area {
            width: 380px;
            margin-inline: auto;
            background-color: var(--container-color);
            padding: 2.5rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 24px hsla(0, 0%, 0%, .1);
        }
        .login__title {
            font-size: var(--big-font-size);
            color: var(--first-color-alt);
            text-align: center;
            margin-bottom: 2rem;
        }
        .login__box {
            position: relative;
            display: flex;
            align-items: center;
            background-color: var(--container-color);
            border-radius: 1rem;
            margin-bottom: 1.25rem; /* Adicionado para espaçamento */
        }
        .login__input {
            background: none;
            width: 100%;
            padding: 1.5rem 2.5rem 1.5rem 1.25rem;
            font-weight: var(--font-semi-bold);
            border: 3px solid transparent;
            border-radius: 1rem;
            z-index: 1;
            transition: border-color .4s;
        }
        .login__label {
            position: absolute;
            left: 1.25rem;
            font-weight: var(--font-semi-bold);
            transition: transform .4s, font-size .4s, color .4s;
        }
        .login__icon {
            position: absolute;
            right: 1rem;
            font-size: 1.25rem;
            transition: color .4s;
        }
        .login__input:focus ~ .login__label {
            transform: translateY(-12px);
            font-size: var(--tiny-font-size);
        }
        .login__input:focus {
            padding-block: 2rem 1rem;
            border-color: var(--first-color);
        }
        .login__input:not(:placeholder-shown).login__input:not(:focus) ~ .login__label {
            transform: translateY(-12px);
            font-size: var(--tiny-font-size);
        }
        .login__input:not(:placeholder-shown).login__input:not(:focus) {
            padding-block: 2rem 1rem;
        }
        .login__input:focus ~ .login__label,
        .login__input:focus ~ .login__icon {
            color: var(--first-color);
        }

        .login__button {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            background-color: var(--first-color);
            color: var(--white-color);
            font-weight: var(--font-semi-bold);
            padding-block: 1.5rem;
            border-radius: 4rem;
            margin-block: 2rem;
            cursor: pointer;
            transition: background-color .4s, box-shadow .4s;
        }
        .login__button:hover {
            background-color: var(--first-color-alt);
        }
        
        /* --- NOSSOS ESTILOS NOVOS --- */
        .mensagem {
            text-align: center;
            font-size: var(--small-font-size);
            font-weight: var(--font-semi-bold);
            padding: 1rem;
            border-radius: .5rem;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
        }
        .mensagem-sucesso {
            background-color: hsl(270, 70%, 97%);  
            color: hsl(270, 60%, 40%);
            border-color: hsl(270, 70%, 90%);
        }
        .mensagem-erro {
            background-color: hsl(0, 70%, 97%);
            color: hsl(0, 60%, 40%);
            border-color: hsl(0, 70%, 90%);
        }
        .login__voltar {
            display: block;
            width: max-content;
            margin: 1rem auto 0 auto;
            font-size: var(--small-font-size);
            font-weight: var(--font-semi-bold);
            color: var(--first-color);
            transition: color .4s;
        }
        .login__voltar:hover {
            color: var(--first-color-alt);
        }
    </style>
</head>
<body>

    <div class="login grid">
        <div class="login__area">
    
            <?php if ($token_valido): ?>
                <h1 class="login__title">Criar Nova Senha</h1>
                <div class="login__access"> <form action="redefinir_senha.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
                        
                        <?php if (!empty($erro)): ?>
                            <div class="mensagem mensagem-erro"><?php echo $erro; ?></div>
                        <?php endif; ?>
                        
                        <div class="login__box">
                            <input type="password" id="nova_senha" name="nova_senha" required class="login__input" placeholder=" ">
                            <label for="nova_senha" class="login__label">Nova Senha</label>
                            <i class="login__icon login__password ri-lock-line"></i>
                        </div>
                        
                        <div class="login__box">
                            <input type="password" id="confirmar_senha" name="confirmar_senha" required class="login__input" placeholder=" ">
                            <label for="confirmar_senha" class="login__label">Confirmar Senha</label>
                            <i class="login__icon login__password ri-lock-line"></i>
                        </div>
                        
                        <button type="submit" class="login__button">Salvar Nova Senha</button>
                    </form>
                </div>
            
            <?php elseif (!empty($sucesso)): ?>
                <h1 class="login__title">Sucesso!</h1>
                <div class="login__access">
                    <div class="mensagem mensagem-sucesso"><?php echo $sucesso; ?></div>
                    <a href="login.php" class="login__voltar">Ir para o Login</a>
                </div>

            <?php else: ?>
                <h1 class="login__title">Link Inválido</h1>
                <div class="login__access">
                    <div class="mensagem mensagem-erro">Este link de redefinição é inválido, expirou ou já foi utilizado.</div>
                    <a href="solicitar_reset.php" class="login__voltar">Solicitar um novo link</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>