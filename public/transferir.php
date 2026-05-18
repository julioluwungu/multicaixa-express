<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transferir | Multicaixa Express</title>

    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <div class="container">

        <div class="card">

            <h1>Transferência</h1>

            <form action="../actions/transferencia_action.php" method="POST">

                <div class="input-group">
                    <label>Email do destinatário</label>
                    <input type="email" name="email_destino" placeholder="exemplo@email.com" required>
                </div>

                <div class="input-group">
                    <label>Valor</label>
                    <input type="number" name="valor" step="0.01" placeholder="0.00" required>
                </div>

                <div class="input-group">
                    <label>Descrição (opcional)</label>
                    <input type="text" name="descricao" placeholder="Ex: pagamento">
                </div>

                <button type="submit">Transferir</button>

            </form>

            <br>

            <a href="dashboard.php" style="color:#FEA734; text-decoration:none;">
                Voltar
            </a>

        </div>

    </div>

</body>
</html>