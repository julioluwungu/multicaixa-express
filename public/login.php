<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit;
}

$modo = $_GET["modo"] ?? "user";

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Multicaixa Express</title>
    <link rel="shortcut icon" href="./assets/icones/favicon.ico" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F3F4F6;
            font-family: Arial, sans-serif;
            color: #111827;
            min-height: 100vh;
        }

        .topbar {
            background: #F59E0B;
            padding: 18px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .logo img {
            width: 40px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 25px 20px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 35px 25px;
            border: 2px solid #E5E7EB;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .titulo {
            text-align: center;
            color: #D97706;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .erro {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.26);
            color: #B91C1C;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: aparecer 0.25s ease;
            line-height: 1.4;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #6B7280;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 14px 14px;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            background: #fff;
            color: #111827;
            font-size: 16px;
            transition: 0.2s;
        }

        .input-group input:focus {
            outline: 2px solid #F59E0B;
            border-color: #F59E0B;
        }

        button {
            width: 100%;
            border: none;
            padding: 16px;
            border-radius: 14px;
            background: #F59E0B;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .acoes {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .btn {
            background: white;
            border: 2px solid #E5E7EB;
            border-radius: 20px;
            padding: 18px;
            text-align: center;
            text-decoration: none;
            color: #F59E0B;
            font-weight: bold;
            transition: 0.3s;
            display: block;
        }

        .btn:hover {
            transform: translateY(-3px);
            border-color: #F59E0B;
        }

        .btn-full {
            grid-column: 1 / -1;
        }

        @media(max-width: 600px) {
            .card {
                padding: 25px 20px;
            }
            
            .titulo {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="logo"><img src="./assets/imagens/logo.png" alt="Logo do Multicaixa Express">Multicaixa Express</div>
</div>

<div class="container">
    <div class="card">
        <h1 class="titulo">
            <?= $modo === "admin" ? "LOGIN ADMINISTRATIVO" : "LOGIN" ?>
        </h1>
        
        <form action="../actions/login_action.php" method="POST">
            <input type="hidden" name="modo" value="<?= $modo ?>">
            
            <?php if (isset($_GET["erro"])): ?>
                <div class="erro">
                    <?php
                    switch ($_GET["erro"]) {
                        case "preencher":
                            echo "Preencha todos os campos.";
                            break;
                        case "nao_encontrado":
                            echo "Utilizador não encontrado.";
                            break;
                        case "senha_incorreta":
                            echo "Senha incorreta.";
                            break;
                        case "sem_permissao":
                            echo "Esta conta não possui acesso administrativo.";
                            break;
                        case "admin_nao":
                            echo "Administradores devem usar o login administrativo.";
                            break;
                        default:
                            echo "Erro ao fazer login.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Digite o seu email" required>
            </div>
            
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite a sua senha" required>
            </div>
            
            <button type="submit">Entrar</button>
        </form>

        <div class="acoes">
            <?php if ($modo === "admin"): ?>
                <a href="login.php?modo=user" class="btn btn-full">
                    Entrar como usuário comum
                </a>
            <?php else: ?>
                <a href="login.php?modo=admin" class="btn btn-full">
                    Entrar como administrador
                </a>
            <?php endif; ?>
            
            <a href="cadastro.php" class="btn btn-full">Ainda não tenho conta</a>
        </div>
    </div>
</div>

<script src="js/login.js"></script>
</body>
</html>