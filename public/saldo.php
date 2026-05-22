<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["id_usuario"];

$sql = "
    SELECT nome, saldo
    FROM usuarios
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Saldo | Multicaixa Express</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F3F4F6;
            font-family: Arial, sans-serif;
            color: #111827;
        }

        .topbar {
            background: #F59E0B;
            padding: 18px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 25px 20px;
        }

        .saldo-card {
            background: white;
            border-radius: 30px;
            padding: 35px 25px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border: 2px solid #E5E7EB;
        }

        .titulo {
            text-align: center;
            color: #D97706;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .saldo-label {
            font-size: 18px;
            color: #6B7280;
            margin-bottom: 12px;
        }

        .saldo-valor {
            font-size: 40px;
            font-weight: bold;
            color: #F59E0B;
            margin-bottom: 10px;
        }

        .nome-usuario {
            color: #9CA3AF;
            font-size: 15px;
        }

        .acoes {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .btn {
            background: white;
            border: 2px solid #E5E7EB;
            border-radius: 20px;
            padding: 18px;
            text-align: center;
            text-decoration: none;
            color: #F59E0B;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            border-color: #F59E0B;
        }

        .voltar-btn {
            grid-column: 1 / -1;
        }

        @media(max-width: 600px) {
            .titulo {
                font-size: 28px;
            }

            .saldo-valor {
                font-size: 32px;
            }
        }

    </style>

</head>
<body>

<div class="topbar">
    <div class="logo">Multicaixa Express</div>
</div>

<div class="container">
    <div class="saldo-card">
        <h1 class="titulo">CONSULTAR SALDO</h1>
        <div class="saldo-label">Saldo disponível</div>

        <div class="saldo-valor">
            <?= number_format($usuario["saldo"], 2, ",", ".") ?> Kz
        </div>

        <div class="nome-usuario">
            <?= htmlspecialchars($usuario["nome"]) ?>
        </div>
    </div>

    <div class="acoes">
        <a href="dashboard.php" class="btn voltar-btn">Voltar</a>
    </div>
</div>

</body>
</html>