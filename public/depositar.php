<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Depositar | Multicaixa Express</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h2 style="color:#FEA734;">Depositar Dinheiro</h2>

    <form action="../actions/depositar_action.php" method="POST">

        <div class="input-group">
            <label>Valor</label>
            <input type="number" name="valor" step="0.01" required>
        </div>

        <div class="input-group">
            <label>Descrição (opcional)</label>
            <input type="text" name="descricao" placeholder="Ex: depósito manual">
        </div>

        <button type="submit">Depositar</button>

    </form>

</div>

</body>
</html>