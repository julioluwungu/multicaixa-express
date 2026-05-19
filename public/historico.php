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
            background: linear-gradient(to bottom right, #050816, #111827);
            font-family: Arial;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .topo {
            margin-bottom: 30px;
        }

        .topo h1 {
            color: #FEA734;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .topo p {
            color: #9ca3af;
        }

        .lista {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .card {
            background: #111827;
            border-radius: 18px;
            padding: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.25);
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
        }

        .info p {
            font-size: 13px;
            color: #9ca3af;
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
            color: #6b7280;
            margin-top: 4px;
        }

        .vazio {
            text-align: center;
            margin-top: 50px;
            color: #9ca3af;
        }

        .voltar {
            display: inline-block;
            margin-top: 30px;
            color: #FEA734;
            text-decoration: none;
        }

        @media(max-width: 768px) {

            .card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .valor {
                text-align: left;
            }

        }

    </style>

</head>
<body>

<div class="container">

    <div class="topo">
        <h1>Histórico</h1>
        <p>Movimentações da sua conta</p>
    </div>

    <?php if (count($transacoes) == 0): ?>

        <div class="vazio">
            Nenhuma transação encontrada.
        </div>

    <?php else: ?>

        <div class="lista">

            <?php foreach ($transacoes as $t): ?>

                <?php
                    $tipo = tipoTransacao($t, $id_usuario);
                    $entrada = $tipo == "entrada";
                ?>

                <div class="card">

                    <div class="lado-esquerdo">

                        <div class="icon <?= $tipo ?>">
                            <?= $entrada ? "↓" : "↑" ?>
                        </div>

                        <div class="info">

                            <?php

                                $isPagamento =

                                    empty($t["id_destino"])

                                    &&

                                    str_contains(
                                        strtolower($t["descricao"]),
                                        "pagamento"
                                    );

                                $isLevantamento =

                                    empty($t["id_destino"])

                                    &&

                                    str_contains(
                                        strtolower($t["descricao"]),
                                        "levantamento"
                                    );

                                if ($isPagamento) {

                                    $titulo = "Pagamento";

                                    $nome = str_replace(
                                        "Pagamento: ",
                                        "",
                                        $t["descricao"]
                                    );

                                }

                                elseif ($isLevantamento) {

                                    $titulo = "Levantamento";

                                    $nome = str_replace(
                                        "Levantamento: ",
                                        "",
                                        $t["descricao"]
                                    );

                                }

                                else {

                                    $titulo = $entrada
                                        ? "Recebido de"
                                        : "Enviado para";

                                    $nome = $entrada
                                        ? $t["remetente"]
                                        : $t["destinatario"];

                                }

                            ?>

                            <h3>
                                <?= $titulo ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($nome) ?>
                            </p>

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

    <a href="dashboard.php" class="voltar">
        ← Voltar ao Dashboard
    </a>

</div>

</body>
</html>