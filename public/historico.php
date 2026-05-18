<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$sql = "
    SELECT t.*, 
           u1.nome AS remetente,
           u2.nome AS destinatario
    FROM transacoes t
    LEFT JOIN usuarios u1 ON t.id_origem = u1.id
    LEFT JOIN usuarios u2 ON t.id_destino = u2.id
    WHERE t.id_origem = ? OR t.id_destino = ?
    ORDER BY t.criado_em DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario, $id_usuario]);

$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Histórico | Multicaixa Express</title>

    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <div class="container">

        <div class="card">

            <h1>Histórico de Transações</h1>

            <?php if (count($transacoes) == 0): ?>
                <p>Nenhuma transação encontrada.</p>
            <?php else: ?>

                <?php foreach ($transacoes as $t): ?>

                    <div class="transacao">

                        <p>
                            <strong>Valor:</strong>
                            <?= number_format($t["valor"], 2, ",", ".") ?> Kz
                        </p>

                        <p>
                            <strong>De:</strong>
                            <?= htmlspecialchars($t["remetente"]) ?>
                        </p>

                        <p>
                            <strong>Para:</strong>
                            <?= htmlspecialchars($t["destinatario"]) ?>
                        </p>

                        <p>
                            <strong>Descrição:</strong>
                            <?= htmlspecialchars($t["descricao"]) ?>
                        </p>

                        <hr>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

            <br>

            <a href="dashboard.php" style="color:#FEA734; text-decoration:none;">
                Voltar
            </a>

        </div>

    </div>

</body>
</html>