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
</head>
<body>

    <div class="container">

        <div class="login-card">

            <h1>Criar Conta</h1>

            <form action="../actions/cadastro_action.php" method="POST">

                <div class="input-group">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Seu nome completo" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Seu email" required>
                </div>

                <div class="input-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" placeholder="Seu telefone">
                </div>

                <div class="input-group">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="Crie uma senha" required>
                </div>

                <button type="submit">Criar Conta</button>

            </form>

        </div>

    </div>

</body>
</html>