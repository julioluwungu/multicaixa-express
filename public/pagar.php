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

    <title>Pagar Serviços | Multicaixa Express</title>

    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <div class="container">

        <div class="card">

            <h1>Pagar Serviços</h1>

            <form action="../actions/pagamento_action.php" method="POST">

                <div class="input-group">
                    <label>Tipo de serviço</label>
                    <select name="servico" required>
                        <option value="">Selecione</option>
                        <option value="energia">Energia</option>
                        <option value="internet">Internet</option>
                        <option value="agua">Água</option>
                        <option value="tv">TV</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Número da referência</label>
                    <input type="text" name="referencia" placeholder="Ex: 123456789" required>
                </div>

                <div class="input-group">
                    <label>Valor</label>
                    <input type="number" name="valor" step="0.01" placeholder="0.00" required>
                </div>

                <button type="submit">Pagar</button>

            </form>

            <br>

            <a href="dashboard.php" style="color:#FEA734; text-decoration:none;">
                Voltar
            </a>

        </div>

    </div>

</body>
</html>