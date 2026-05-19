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
    <title>Usuários | Admin</title>

    <style>

        body {
            background: #050816;
            font-family: Arial;
            margin: 0;
            padding: 20px;
            color: white;
        }

        .topo {
            margin-bottom: 25px;
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

        .usuarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .usuario-card {
            background: #111827;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .usuario-card h2 {
            margin-top: 0;
            color: #FEA734;
            font-size: 20px;
        }

        .info {
            margin-bottom: 10px;
            color: #d1d5db;
        }

        .saldo {
            font-size: 22px;
            font-weight: bold;
            margin: 15px 0;
            color: #22c55e;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .user {
            background: #1e3a8a;
        }

        .admin {
            background: #92400e;
        }

        .super_admin {
            background: #7f1d1d;
        }

        .acoes {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            background: #FEA734;
            color: #050816;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .delete-btn {
            background: #dc2626;
            color: white;
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

    <h1>Gerir Usuários</h1>

    <p>Controle das contas do sistema</p>

    <a href="index.php" class="voltar">
        ← Voltar ao painel
    </a>

</div>

<div class="usuarios-grid">

    <?php foreach ($usuarios as $u): ?>

        <div class="usuario-card">

            <h2><?= htmlspecialchars($u["nome"]) ?></h2>

            <div class="info">
                <?= htmlspecialchars($u["email"]) ?>
            </div>

            <div class="saldo">
                <?= number_format($u["saldo"], 2, ',', '.') ?> Kz
            </div>

            <span class="badge <?= $u["tipo"] ?>">
                <?= strtoupper($u["tipo"]) ?>
            </span>

            <div class="acoes">

                <a href="depositar.php?id=<?= $u["id"] ?>" class="btn">
                    Depositar
                </a>

                <?php if ($u["tipo"] !== "super_admin"): ?>

                    <a
                        href="../../actions/eliminar_usuario.php?id=<?= $u["id"] ?>"
                        class="btn delete-btn"
                        onclick="return confirm('Tem certeza que deseja eliminar esta conta?')"
                    >
                        Eliminar
                    </a>

                <?php endif; ?>

            </div>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>