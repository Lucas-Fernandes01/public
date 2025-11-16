<?php
include 'conexao.php';
$mensagem = "";
$tipo_mensagem = ""; // "sucesso" ou "erro"
$link_reset = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT id FROM cadastro_usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expira_em = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $sql_insert = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $email, $token, $expira_em);
        $stmt_insert->execute();

        // Ajuste o /public/ se o caminho do seu localhost for diferente
        $link_reset = "http://localhost/public/redefinir_senha.php?token=" . $token; 
        
        $mensagem = "Solicitação recebida. Para continuar, utilize o link de redefinição abaixo.";
        $tipo_mensagem = "sucesso";

    } else {
        $mensagem = "O e-mail informado não foi encontrado em nosso sistema.";
        $tipo_mensagem = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Açaí</title>
    
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
        /* Parágrafo de descrição */
        .login__descricao {
            text-align: center; 
            margin-bottom: 1.5rem;
            font-size: var(--normal-font-size);
        }

    </style>
</head>
<body>

    <div class="login grid">
        <div class="login__area">
            
            <h1 class="login__title">Recuperar Senha</h1>

            <div class="login__access"> <?php if (!empty($mensagem)): ?>
                    <div class="mensagem <?php echo $tipo_mensagem == 'sucesso' ? 'mensagem-sucesso' : 'mensagem-erro'; ?>">
                        <?php echo $mensagem; ?>
                        
                        <?php if (!empty($link_reset)): ?>
                            <a href="<?php echo $link_reset; ?>" style="display:block; margin-top:10px; font-weight:bold; word-break:break-all;">
                                Clique aqui para redefinir
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($link_reset)): ?>
                    <p class="login__descricao">
                        Insira seu e-mail para enviarmos um link de recuperação.
                    </p>
                    <form action="solicitar_reset.php" method="POST">
                        <div class="login__box">
                            <input type="email" name="email" required class="login__input" id="email" placeholder=" ">
                            <label for="email" class="login__label">E-mail</label>
                            <i class="login__icon ri-mail-line"></i>
                        </div>
                        
                        <button type="submit" class="login__button">Enviar Link</button>
                    </form>
                <?php endif; ?>

                <a href="login.php" class="login__voltar">Voltar para o Login</a>
            </div>
        </div>
    </div>

</body>
</html>