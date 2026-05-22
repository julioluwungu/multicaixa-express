<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$sql = "
    SELECT t.*, u1.nome AS remetente, u2.nome AS destinatario
    FROM transacoes t
    LEFT JOIN usuarios u1 ON t.id_origem = u1.id
    LEFT JOIN usuarios u2 ON t.id_destino = u2.id
    WHERE t.id_origem = ? OR t.id_destino = ?
    ORDER BY t.criado_em DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario, $id_usuario]);
$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatarValor($valor) {
    return number_format($valor, 2, ",", ".") . " Kz";
}

function tipoTransacao($t, $id_usuario) {
    return $t["id_origem"] == $id_usuario ? "saida" : "entrada";
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico | Multicaixa Express</title>
    
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
            text-align: center;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 26px 18px;
            border: 2px solid #E5E7EB;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .titulo {
            text-align: center;
            color: #D97706;
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .subtitulo {
            text-align: center;
            color: #6B7280;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .lista {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .transacao-card {
            background: white;
            border-radius: 18px;
            padding: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 2px solid #E5E7EB;
            transition: 0.3s;
        }

        .transacao-card:hover {
            transform: translateY(-2px);
            border-color: #F59E0B;
        }

        .lado-esquerdo {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
        }

        .entrada {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .saida {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .info h3 {
            font-size: 16px;
            margin-bottom: 5px;
            color: #111827;
        }

        .info p {
            font-size: 13px;
            color: #6B7280;
        }

        .valor {
            text-align: right;
        }

        .valor strong {
            font-size: 16px;
            display: block;
        }

        .entrada-texto {
            color: #22c55e;
        }

        .saida-texto {
            color: #ef4444;
        }

        .data {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 4px;
        }

        .vazio {
            text-align: center;
            color: #6B7280;
            background: #F9FAFB;
            padding: 40px;
            border-radius: 18px;
            border: 2px solid #E5E7EB;
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

        @media(max-width: 768px) {
            .transacao-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .valor {
                text-align: left;
            }
            
            .titulo {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="logo">Multicaixa Express</div>
</div>

<div class="container">
    <div class="card">
        <h1 class="titulo">HISTÓRICO</h1>
        <p class="subtitulo">Movimentações da sua conta</p>

        <?php if (count($transacoes) == 0): ?>
            <div class="vazio">Nenhuma transação encontrada.</div>
        <?php else: ?>
            <div class="lista">
                <?php foreach ($transacoes as $t): ?>
                    <?php
                        $tipo = tipoTransacao($t, $id_usuario);
                        $entrada = $tipo == "entrada";
                    ?>

                    <div class="transacao-card">
                        <div class="lado-esquerdo">
                            <div class="icon <?= $tipo ?>"><?= $entrada ? "↓" : "↑" ?></div>
                            <div class="info">
                                <?php
                                    $isPagamento = empty($t["id_destino"]) && str_contains(strtolower($t["descricao"]), "pagamento");
                                    $isLevantamento = empty($t["id_destino"]) && !$isPagamento;

                                    if ($isPagamento) {
                                        $titulo = "Pagamento";
                                        $nome = str_replace("Pagamento: ", "", $t["descricao"]);
                                    }
                                    elseif ($isLevantamento) {
                                        $titulo = "Levantamento";
                                        $nome = str_replace("Levantamento: ", "", $t["descricao"]);
                                    }
                                    else {
                                        $titulo = $entrada ? "Recebido de" : "Enviado para";
                                        $nome = $entrada ? $t["remetente"] : $t["destinatario"];
                                    }
                                ?>
                                <h3><?= $titulo ?></h3>
                                <p><?= htmlspecialchars($nome) ?></p>
                            </div>
                        </div>

                        <div class="valor">
                            <strong class="<?= $tipo ?>-texto">
                                <?= $entrada ? "+" : "-" ?>
                                <?= formatarValor($t["valor"]) ?>
                            </strong>
                            <div class="data">
                                <?= date("d/m/Y H:i", strtotime($t["criado_em"])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="acoes">
            <a href="dashboard.php" class="btn voltar-btn">
                Voltar
            </a>
        </div>
    </div>
</div>

</body>
</html>