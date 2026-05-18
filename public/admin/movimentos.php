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

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentos</title>

    <style>

        body {
            background: #050816;
            font-family: Arial;
            margin: 0;
            padding: 20px;
            color: white;
        }

        .topo {
            margin-bottom: 30px;
        }

        .topo h1 {
            color: #FEA734;
            margin-bottom: 5px;
        }

        .voltar {
            display: inline-block;
            margin-top: 10px;
            color: #FEA734;
            text-decoration: none;
        }

        .movimentos-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .movimento-card {
            background: #111827;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .nome {
            font-size: 18px;
            font-weight: bold;
            color: #FEA734;
        }

        .tipo {
            margin-top: 8px;
            font-weight: bold;
        }

        .valor {
            margin-top: 10px;
            font-size: 22px;
            font-weight: bold;
            color: #22c55e;
        }

        .descricao {
            margin-top: 10px;
            color: #9ca3af;
        }

        .data {
            margin-top: 10px;
            font-size: 13px;
            color: #6b7280;
        }

        @media(max-width: 768px) {

            body {
                padding: 15px;
            }

        }

    </style>
</head>

<body>

<div class="topo">

    <h1>Movimentos</h1>

    <p>Histórico financeiro do sistema</p>

    <a href="index.php" class="voltar">
        ← Voltar ao painel
    </a>

</div>

<div class="movimentos-container">

    <?php if (count($movimentos) > 0): ?>

        <?php foreach ($movimentos as $m): ?>

            <div class="movimento-card">

                <div class="nome">
                    <?= htmlspecialchars($m["nome"]) ?>
                </div>

                <div class="tipo">
                    <?= strtoupper($m["tipo"]) ?>
                </div>

                <div class="valor">
                    <?= number_format($m["valor"], 2, ',', '.') ?> Kz
                </div>

                <?php if (!empty($m["descricao"])): ?>

                    <div class="descricao">
                        <?= htmlspecialchars($m["descricao"]) ?>
                    </div>

                <?php endif; ?>

                <div class="data">
                    <?= $m["criado_em"] ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum movimento encontrado.</p>

    <?php endif; ?>

</div>

</body>
</html>