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

    <title>Login | Multicaixa Express</title>

    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <div class="container">

        <div class="login-card">

            <h1>Multicaixa Express</h1>

            <form action="../actions/login_action.php" method="POST">

                <div class="input-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Digite o seu email"
                        required
                    >
                </div>

                <div class="input-group">
                    <label for="senha">Senha</label>

                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        placeholder="Digite a sua senha"
                        required
                    >
                </div>

                <button type="submit">
                    Entrar
                </button>

            </form>

        </div>

    </div>

    <script src="js/login.js"></script>

</body>
</html>