<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$usuarios = $conn->query("SELECT id, nome, email, saldo, tipo FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">

    <h2>Usuários</h2>

    <?php foreach ($usuarios as $u): ?>
        <div class="transacao">
            <strong><?= $u["nome"] ?></strong><br>
            <?= $u["email"] ?><br>
            <?= number_format($u["saldo"], 2, ',', '.') ?> Kz<br>
            Tipo: <?= $u["tipo"] ?>
        </div>
    <?php endforeach; ?>

</div>

</body>
</html>