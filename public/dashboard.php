<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["id_usuario"];

$sql = "SELECT nome, email, saldo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Multicaixa Express</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background: #0F172A;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logout-btn {
            background: #dc2626;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.3s;
            white-space: nowrap;
        }

        .logout-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .user {
            font-size: 14px;
            color: #CBD5E1;
        }

        .card-saldo {
            background: linear-gradient(135deg, #FEA734, #ffb85c);
            color: #111827;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 20px;
        }

        .saldo-title {
            font-size: 14px;
            opacity: 0.8;
        }

        .saldo-value {
            font-size: 32px;
            font-weight: bold;
            margin-top: 5px;
        }

        .grid-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .action {
            background: #111827;
            border: 1px solid rgba(254, 167, 52, 0.15);
            padding: 18px;
            border-radius: 14px;
            text-align: center;
            color: white;
            transition: 0.3s;
            font-size: 14px;
        }

        .action:hover {
            background: #FEA734;
            color: #111827;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            color: #94A3B8;
            margin: 15px 0 10px;
        }

        .transacao {
            background: #111827;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 10px;
            border-left: 3px solid #FEA734;
        }

        .transacao small {
            color: #94A3B8;
        }

        @media (max-width: 600px) {
            .grid-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

</head>

<body>

<div class="container">

    <div class="top">
        <div>
            <h2 style="color:#FEA734;">Olá, <?= htmlspecialchars($usuario["nome"]) ?></h2>
            <div class="user"><?= htmlspecialchars($usuario["email"]) ?></div>
        </div>

        <a href="../actions/logout.php" class="logout-btn">Sair</a>
    </div>

    <div class="card-saldo">
        <div class="saldo-title">Saldo disponível</div>
        <div class="saldo-value">
            <?= number_format($usuario["saldo"], 2, ",", ".") ?> Kz
        </div>
    </div>

    <div class="grid-actions">

        <a class="action" href="transferir.php">Transferir</a>
        <a class="action" href="levantar.php">Levantar</a>
        <a class="action" href="pagar.php">Pagar</a>
        <a class="action" href="historico.php">Histórico</a>

    </div>

    <div class="section-title">Últimas movimentações</div>

    <?php

    $sql = "SELECT * FROM transacoes 
            WHERE id_origem = ? OR id_destino = ?
            ORDER BY criado_em DESC LIMIT 5";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id, $id]);

    $transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($transacoes as $t):
    ?>

        <div class="transacao">
            <div><strong><?= number_format($t["valor"], 2, ",", ".") ?> Kz</strong></div>
            <small><?= htmlspecialchars($t["descricao"]) ?></small>
        </div>

    <?php endforeach; ?>

</div>

</body>
</html>