<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["id_usuario"];

$sql = "
    SELECT nome, email, saldo
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
    <title>Dashboard | Multicaixa Express</title>
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
            position: relative;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .logo img {
            width: 40px;
        }

        .menu-btn {
            position: absolute;
            left: 20px;
            color: white;
            font-size: 40px;
            cursor: pointer;
            user-select: none;
            transition: 0.2s;
        }

        .menu-btn:hover {
            transform: scale(1.1);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.4);
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
            z-index: 998;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .side-menu {
            position: fixed;
            top: 0;
            left: -260px;
            width: 240px;
            height: 100vh;
            background: #fff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            padding-top: 80px;
            transition: 0.3s ease;
            z-index: 999;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .side-menu.active {
            left: 0;
        }

        .side-menu a {
            display: block;
            padding: 16px 20px;
            text-decoration: none;
            color: #DC2626;
            font-size: 15px;
            font-weight: bold;
            border-bottom: 1px solid #F3F4F6;
            transition: 0.2s;
        }

        .side-menu a:hover {
            background: #FEF3C7;
            padding-left: 25px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
        }

        .titulo {
            text-align: center;
            color: #D97706;
            margin-bottom: 25px;
            font-size: 34px;
            font-weight: bold;
        }

        .card-area {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .bank-card {
            width: 100%;
            max-width: 420px;
            height: 240px;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.18);
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-top: 20px;
        }

        .item {
            background: white;
            border-radius: 24px;
            padding: 25px 15px;
            text-align: center;
            text-decoration: none;
            color: #6B7280;
            border: 2px solid #E5E7EB;
            transition: 0.3s;
            min-height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .item:hover {
            transform: translateY(-5px);
            border-color: #F59E0B;
        }

        .icon-area {
            width: 70px;
            height: 70px;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .icon-area img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .item span {
            font-size: 16px;
            font-weight: bold;
            color: #F59E0B;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #9CA3AF;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 25px;
            }

            .logo img {
                width: 35px;
            }
        }

    </style>

</head>

<body>

<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<div class="side-menu" id="sideMenu">
    <a href="../actions/logout.php">Sair da Conta</a>
</div>

<div class="topbar">
    <div class="menu-btn" onclick="toggleMenu()">⋮</div>
    <div class="logo"><img src="./assets/imagens/logo.png" alt="Logo do Multicaixa Express">Multicaixa Express</div>
</div>

<div class="container">
    <h1 class="titulo">CARTÃO</h1>
    <div class="card-area">
        <div class="bank-card">
            <img src="assets/imagens/cartao-multicaixa.png" class="card-image">
        </div>
    </div>

    <div class="grid">
        <a href="transferir.php" class="item">
            <div class="icon-area">
                <img src="assets/icones/transferir.png">
            </div>
            <span>Transferir</span>
        </a>
        <a href="pagar.php" class="item">
            <div class="icon-area">
                <img src="assets/icones/pagar.png">
            </div>
            <span>Pagar</span>
        </a>
        <a href="historico.php" class="item">
            <div class="icon-area">
                <img src="assets/icones/historico.png">
            </div>
            <span>Histórico</span>
        </a>
        <a href="saldo.php" class="item">
            <div class="icon-area">
                <img src="assets/icones/consultar-saldo.png">
            </div>
            <span>Consultar Saldo</span>
        </a>
    </div>
    <div class="footer">
        © <?= date("Y") ?> Multicaixa Express
    </div>
</div>

<script>
function toggleMenu() {
    document.getElementById("sideMenu").classList.toggle("active");
    document.getElementById("overlay").classList.toggle("active");
}
</script>

</body>
</html>