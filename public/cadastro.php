<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Multicaixa Express</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        .error {
            background: #7f1d1d;
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .strength {
            font-size: 12px;
            margin-top: 5px;
        }

        .weak { color: #ef4444; }
        .medium { color: #f59e0b; }
        .strong { color: #22c55e; }

        .match {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-card">
        <h1>Criar Conta</h1>

        <?php if (isset($_GET["erro"])): ?>

            <div class="error">
                <?php
                switch ($_GET["erro"]) {
                    case "senha_diferente":
                        echo "As senhas não coincidem.";
                        break;
                    case "email_existe":
                        echo "Este email já está registado.";
                        break;
                    default:
                        echo "Erro ao criar conta.";
                }
                ?>
            </div>

        <?php endif; ?>

        <form action="../actions/cadastro_action.php" method="POST">
            <div class="input-group">
                <label>Nome</label>
                <input type="text" name="nome" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>Telefone</label>
                <input type="text" name="telefone">
            </div>
            <div class="input-group">
                <label>Senha</label>
                <input type="password" name="senha" id="senha" required>
                <div id="forcaSenha" class="strength"></div>
            </div>
            <div class="input-group">
                <label>Confirmar Senha</label>
                <input type="password" name="confirmar_senha" id="confirmar" required>
                <div id="matchSenha" class="match"></div>
            </div>
            <button type="submit">Criar Conta</button>
            <div style="margin-top:15px; text-align:center;">
                <a href="login.php" style="color:#FEA734;">Já tenho conta</a>
            </div>
        </form>
    </div>
</div>

<script src="js/cadastro.js"></script>

</body>
</html>