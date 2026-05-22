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
    <title>Movimentos | Admin | Multicaixa Express</title>
    
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

        .container {
            max-width: 900px;
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

        .movimentos-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .movimento-card {
            background: #F9FAFB;
            border-radius: 18px;
            padding: 20px;
            border: 2px solid #E5E7EB;
            transition: 0.3s;
        }

        .movimento-card:hover {
            transform: translateY(-2px);
            border-color: #F59E0B;
        }

        .nome {
            font-size: 18px;
            font-weight: bold;
            color: #D97706;
            margin-bottom: 8px;
        }

        .tipo {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 8px;
        }

        .tipo-transferencia {
            background: rgba(245, 158, 11, 0.15);
            color: #F59E0B;
        }

        .tipo-pagamento {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .tipo-deposito {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .tipo-levantamento {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .valor {
            margin-top: 12px;
            font-size: 24px;
            font-weight: bold;
            color: #22c55e;
        }

        .descricao {
            margin-top: 10px;
            color: #6B7280;
            font-size: 14px;
        }

        .data {
            margin-top: 10px;
            font-size: 12px;
            color: #9CA3AF;
        }

        .vazio {
            text-align: center;
            color: #6B7280;
            padding: 40px;
            background: #F9FAFB;
            border-radius: 18px;
            border: 2px solid #E5E7EB;
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
            
            .card {
                padding: 25px 20px;
            }
            
            .valor {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1 class="titulo">MOVIMENTOS</h1>
        <p class="subtitulo">Histórico financeiro do sistema</p>

        <div class="movimentos-container">
            <?php if (count($movimentos) > 0): ?>
                <?php foreach ($movimentos as $m): ?>
                    <?php
                        $tipoClass = '';
                        switch ($m["tipo"]) {
                            case 'transferencia':
                                $tipoClass = 'tipo-transferencia';
                                break;
                            case 'pagamento':
                                $tipoClass = 'tipo-pagamento';
                                break;
                            case 'deposito':
                                $tipoClass = 'tipo-deposito';
                                break;
                            case 'levantamento':
                                $tipoClass = 'tipo-levantamento';
                                break;
                            default:
                                $tipoClass = 'tipo-transferencia';
                        }
                    ?>
                    <div class="movimento-card">
                        <div class="nome"><?= htmlspecialchars($m["nome"]) ?></div>
                        <div class="tipo <?= $tipoClass ?>"><?= strtoupper($m["tipo"]) ?></div>
                        <div class="valor">💰 <?= number_format($m["valor"], 2, ',', '.') ?> Kz</div>

                        <?php if (!empty($m["descricao"])): ?>
                            <div class="descricao">📝 <?= htmlspecialchars($m["descricao"]) ?></div>
                        <?php endif; ?>

                        <div class="data">📅 <?= date("d/m/Y H:i", strtotime($m["criado_em"])) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="vazio">Nenhum movimento encontrado.</div>
            <?php endif; ?>
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