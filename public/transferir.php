<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferir | Multicaixa Express</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(to bottom right, #050816, #111827);
            font-family: Arial;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 480px;
            background: #111827;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 0 25px rgba(0,0,0,0.4);
        }

        .icone {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(254, 167, 52, 0.15);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            font-size: 30px;
        }

        .topo {
            margin-bottom: 30px;
        }

        .topo h1 {
            color: #FEA734;
            margin-bottom: 8px;
            font-size: 30px;
        }

        .topo p {
            color: #9ca3af;
            font-size: 15px;
            line-height: 1.5;
        }

        .input-group {
            margin-bottom: 22px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #d1d5db;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            background: #1f2937;
            color: white;
            font-size: 16px;
            transition: 0.3s;
        }

        .input-group input:focus {
            outline: 2px solid #FEA734;
        }

        .input-group input::placeholder {
            color: #6b7280;
        }

        button {
            width: 100%;
            border: none;
            padding: 16px;
            border-radius: 14px;
            background: #FEA734;
            color: #050816;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            opacity: 0.92;
            transform: translateY(-2px);
        }

        .voltar {
            display: inline-block;
            margin-top: 22px;
            color: #FEA734;
            text-decoration: none;
            font-size: 14px;
        }

        .info-box {
            background: rgba(254, 167, 52, 0.08);
            border: 1px solid rgba(254, 167, 52, 0.15);
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 22px;
            color: #d1d5db;
            font-size: 14px;
            line-height: 1.5;
        }

        .erro {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 22px;
            font-size: 14px;
            animation: aparecer 0.3s ease;
        }

        @keyframes aparecer {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        @media(max-width: 768px) {
            .card {
                padding: 25px;
            }

            .topo h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icone">💸</div>
        <div class="topo">
            <h1>Transferência</h1>
            <p>Envie dinheiro para outros usuários do sistema de forma rápida e segura.</p>
        </div>

        <?php if (isset($_GET["erro"])): ?>

            <div class="erro">

                <?php

                    switch ($_GET["erro"]) {
                        case "saldo":
                            echo "Saldo insuficiente.";
                            break;
                        case "valor":
                            echo "Valor inválido.";
                            break;
                        case "email":
                            echo "Informe o email do destinatário.";
                            break;
                        case "destino":
                            echo "Destinatário não encontrado.";
                            break;
                        case "origem":
                            echo "Conta de origem não encontrada.";
                            break;
                        case "proprio":
                            echo "Não pode transferir para si mesmo.";
                            break;
                        default:
                            echo "Erro ao realizar transferência.";
                    }

                ?>

            </div>

        <?php endif; ?>

        <div class="info-box">Certifique-se de que o email do destinatário está correto
            antes de confirmar a transferência.</div>

        <form action="../actions/transferencia_action.php" method="POST">
            <div class="input-group">
                <label>Email do destinatário</label>
                <input type="email" name="email_destino" placeholder="exemplo@email.com" required>
            </div>
            <div class="input-group">
                <label>Valor</label>
                <input type="number" name="valor" step="0.01" placeholder="0.00 Kz" required>
            </div>
            <div class="input-group">
                <label>Descrição (opcional)</label>
                <input type="text" name="descricao" placeholder="Ex: pagamento">
            </div>
            <button type="submit">Transferir Dinheiro</button>
        </form>

        <a href="dashboard.php" class="voltar">← Voltar ao Dashboard</a>

    </div>
</body>
</html>