<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$totalUsers = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

$totalSaldo = $conn->query("
    SELECT SUM(saldo) FROM usuarios
")->fetchColumn();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>

        body {
            background: #050816;
            font-family: Arial;
            color: white;
            margin: 0;
            padding: 20px;
        }

        .topo {
            margin-bottom: 30px;
        }

        .topo h1 {
            color: #FEA734;
            margin-bottom: 5px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: #111827;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .card h3 {
            margin: 0;
            font-size: 16px;
            color: #9ca3af;
        }

        .card p {
            margin-top: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #FEA734;
        }

        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: #FEA734;
            color: #050816;
            text-decoration: none;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            font-weight: bold;
            transition: 0.3s;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .movimentos {
            background: #111827;
            border-radius: 16px;
            padding: 20px;
        }

        .movimentos h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .movimento {
            border-bottom: 1px solid #1f2937;
            padding: 12px 0;
        }

        .movimento:last-child {
            border-bottom: none;
        }

        .tipo {
            color: #FEA734;
            font-weight: bold;
        }

        @media(max-width: 768px) {

            body {
                padding: 15px;
            }

            .card p {
                font-size: 22px;
            }

        }

    </style>
</head>

<body>

<div class="topo">
    <h1>Painel Admin</h1>
    <p>Controle completo do sistema</p>
</div>

<div class="cards">

    <div class="card">
        <h3>Total de Usuários</h3>
        <p><?= $totalUsers ?></p>
    </div>

    <div class="card">
        <h3>Saldo Total</h3>
        <p><?= number_format($totalSaldo, 2, ',', '.') ?> Kz</p>
    </div>

</div>

<div class="actions">

    <a href="usuarios.php" class="action-btn">
        Gerir Usuários
    </a>

    <a href="depositar.php" class="action-btn">
        Fazer Depósito
    </a>

    <a href="movimentos.php" class="action-btn">
        Ver Movimentos
    </a>

</div>

<div class="movimentos">

    <h2>Últimos Movimentos</h2>

    <?php if (count($movimentos) > 0): ?>

        <?php foreach ($movimentos as $m): ?>

            <div class="movimento">

                <strong><?= $m["nome"] ?></strong><br>

                <span class="tipo">
                    <?= ucfirst($m["tipo"]) ?>
                </span>

                — <?= number_format($m["valor"], 2, ',', '.') ?> Kz

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum movimento encontrado.</p>

    <?php endif; ?>

</div>

</body>
</html>