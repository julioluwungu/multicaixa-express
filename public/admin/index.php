<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$totalUsers = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$totalSaldo = $conn->query("SELECT SUM(saldo) FROM usuarios")->fetchColumn();

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
    <title>Painel Admin | Multicaixa Express</title>
    
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
            min-height: 100vh;
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
            max-width: 1200px;
            margin: auto;
            padding: 25px 20px;
        }

        .titulo {
            text-align: center;
            color: #D97706;
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitulo {
            text-align: center;
            color: #6B7280;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 2px solid #E5E7EB;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            transition: 0.3s;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: #F59E0B;
        }

        .card h3 {
            font-size: 16px;
            color: #6B7280;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 36px;
            font-weight: bold;
            color: #F59E0B;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
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
            min-height: 140px;
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

        .movimentos-card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 2px solid #E5E7EB;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .movimentos-card h2 {
            color: #D97706;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .movimento {
            border-bottom: 1px solid #E5E7EB;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .movimento:last-child {
            border-bottom: none;
        }

        .movimento-info {
            flex: 1;
        }

        .movimento-nome {
            font-weight: bold;
            color: #111827;
            margin-bottom: 5px;
        }

        .movimento-tipo {
            font-size: 13px;
            color: #F59E0B;
            font-weight: bold;
        }

        .movimento-valor {
            font-weight: bold;
            font-size: 18px;
            color: #F59E0B;
        }

        .vazio {
            text-align: center;
            color: #6B7280;
            padding: 40px;
        }

        @media(max-width: 768px) {
            .titulo {
                font-size: 28px;
            }

            .logo {
                font-size: 25px;
            }

            .logo img {
                width: 35px;
            }
            
            .card p {
                font-size: 28px;
            }
            
            .movimento {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<div class="side-menu" id="sideMenu">
    <a href="../../actions/logout.php">Sair da Conta</a>
</div>

<div class="topbar">
    <div class="menu-btn" onclick="toggleMenu()">⋮</div>
    <div class="logo"><img src="../assets/imagens/logo.png" alt="Logo do Multicaixa Express">Multicaixa Express</div>
</div>

<div class="container">
    <h1 class="titulo">PAINEL ADMIN</h1>
    <p class="subtitulo">Controle completo do sistema</p>

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

    <div class="grid">
        <a href="usuarios.php" class="item">
            <div class="icon-area">
                <img src="../assets/icones/usuario.png" alt="Gerir Usuários">
            </div>
            <span>Gerir Usuários</span>
        </a>
        <a href="depositar.php" class="item">
            <div class="icon-area">
                <img src="../assets/icones/depositar.png" alt="Fazer Depósito">
            </div>
            <span>Fazer Depósito</span>
        </a>
        <a href="movimentos.php" class="item">
            <div class="icon-area">
                <img src="../assets/icones/movimentos.png" alt="Ver Movimentos">
            </div>
            <span>Ver Movimentos</span>
        </a>
    </div>

    <div class="movimentos-card">
        <h2>Últimos Movimentos</h2>

        <?php if (count($movimentos) > 0): ?>
            <?php foreach ($movimentos as $m): ?>
                <div class="movimento">
                    <div class="movimento-info">
                        <div class="movimento-nome"><?= htmlspecialchars($m["nome"]) ?></div>
                        <div class="movimento-tipo"><?= ucfirst($m["tipo"]) ?></div>
                    </div>
                    <div class="movimento-valor">
                        <?= number_format($m["valor"], 2, ',', '.') ?> Kz
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="vazio">Nenhum movimento encontrado.</div>
        <?php endif; ?>
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