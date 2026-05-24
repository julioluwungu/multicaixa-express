<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$usuarios = $conn->query("
    SELECT id, nome, email, saldo, tipo
    FROM usuarios
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários | Admin | Multicaixa Express</title>
    <link rel="shortcut icon" href="../assets/icones/favicon.ico" type="image/x-icon">
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

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 25px 20px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 35px 25px;
            border: 2px solid #E5E7EB;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
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

        .usuarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .usuario-card {
            background: #F9FAFB;
            border-radius: 20px;
            padding: 20px;
            border: 2px solid #E5E7EB;
            transition: 0.3s;
        }

        .usuario-card:hover {
            transform: translateY(-3px);
            border-color: #F59E0B;
        }

        .usuario-card h2 {
            color: #D97706;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .info {
            color: #6B7280;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .saldo {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
            color: #22c55e;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .user {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .admin {
            background: rgba(245, 158, 11, 0.15);
            color: #F59E0B;
        }

        .super_admin {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .acoes-card {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            background: white;
            border: 2px solid #E5E7EB;
            border-radius: 14px;
            padding: 10px 16px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
            color: #F59E0B;
            cursor: pointer;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-2px);
            border-color: #F59E0B;
        }

        .delete-btn {
            color: #ef4444;
        }

        .delete-btn:hover {
            border-color: #ef4444;
        }

        .acoes {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .btn-voltar {
            background: white;
            border: 2px solid #E5E7EB;
            border-radius: 20px;
            padding: 18px;
            text-align: center;
            text-decoration: none;
            color: #F59E0B;
            font-weight: bold;
            transition: 0.3s;
            display: block;
        }

        .btn-voltar:hover {
            transform: translateY(-3px);
            border-color: #F59E0B;
        }

        .voltar-btn {
            grid-column: 1 / -1;
        }

        @media(max-width: 768px) {
            .titulo {
                font-size: 28px;
            }
            
            .usuarios-grid {
                grid-template-columns: 1fr;
            }
            
            .card {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
<div class="topbar">
    <div class="logo"><img src="../assets/imagens/logo.png" alt="Logo do Multicaixa Express">Multicaixa Express</div>
</div>

<div class="container">
    <div class="card">
        <h1 class="titulo">GERIR USUÁRIOS</h1>
        <p class="subtitulo">Controle das contas do sistema</p>

        <div class="usuarios-grid">
            <?php foreach ($usuarios as $u): ?>
                <div class="usuario-card">
                    <h2><?= htmlspecialchars($u["nome"]) ?></h2>
                    <div class="info">📧 <?= htmlspecialchars($u["email"]) ?></div>
                    <div class="saldo">💰 <?= number_format($u["saldo"], 2, ',', '.') ?> Kz</div>
                    <span class="badge <?= $u["tipo"] ?>"><?= strtoupper($u["tipo"]) ?></span>
                    <div class="acoes-card">
                        <a href="depositar.php?id=<?= $u["id"] ?>" class="btn">+ Depositar</a>

                        <?php if ($u["tipo"] !== "super_admin"): ?>
                            <a href="../../actions/eliminar_usuario.php?id=<?= $u["id"] ?>" class="btn delete-btn" onclick="return confirm('Tem certeza que deseja eliminar esta conta?')">🗑 Eliminar</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="acoes">
            <a href="index.php" class="btn-voltar voltar-btn">
                Voltar
            </a>
        </div>
    </div>
</div>

</body>
</html>