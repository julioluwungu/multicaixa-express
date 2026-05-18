<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$movimentos = $conn->query("
    SELECT m.*, u.nome
    FROM movimentos m
    JOIN usuarios u ON u.id = m.id_usuario
    ORDER BY m.criado_em DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">

    <h2>Movimentos</h2>

    <?php foreach ($movimentos as $m): ?>
        <div class="transacao">
            <strong><?= $m["nome"] ?></strong><br>
            <?= $m["tipo"] ?> - <?= number_format($m["valor"], 2, ',', '.') ?> Kz
        </div>
    <?php endforeach; ?>

</div>