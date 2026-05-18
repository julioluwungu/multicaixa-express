<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

/* total usuários */
$totalUsers = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

/* saldo total do sistema */
$totalSaldo = $conn->query("SELECT SUM(saldo) FROM usuarios")->fetchColumn();

/* últimas atividades */
$movimentos = $conn->query("
    SELECT m.*, u.nome
    FROM movimentos m
    JOIN usuarios u ON u.id = m.id_usuario
    ORDER BY m.criado_em DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">

    <h2 style="color:#FEA734;">Painel Admin</h2>

    <div class="grid-actions">

        <div class="action">
            <strong>Usuários</strong><br>
            <?= $totalUsers ?>
        </div>

        <div class="action">
            <strong>Saldo Total</strong><br>
            <?= number_format($totalSaldo, 2, ',', '.') ?> Kz
        </div>

    </div>

    <h3>Últimos movimentos</h3>

    <?php foreach ($movimentos as $m): ?>
        <div class="transacao">
            <strong><?= $m["nome"] ?></strong><br>
            <?= $m["tipo"] ?> - <?= number_format($m["valor"], 2, ',', '.') ?> Kz
        </div>
    <?php endforeach; ?>

    <div class="grid-actions">

        <a class="action" href="usuarios.php">Gerir Usuários</a>
        <a class="action" href="depositar.php">Depósitos</a>
        <a class="action" href="movimentos.php">Movimentos</a>

    </div>

</div>

</body>
</html>