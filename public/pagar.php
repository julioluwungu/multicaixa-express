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
    <title>Pagar Serviços | Multicaixa Express</title>
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
            max-width: 500px;
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

        .input-group input,
        .input-group select {

            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            background: #1f2937;
            color: white;
            font-size: 16px;
            transition: 0.3s;

        }

        .input-group input:focus,
        .input-group select:focus {
            outline: 2px solid #FEA734;
        }

        .input-group input::placeholder {
            color: #6b7280;
        }

        select option {
            background: #111827;
            color: white;
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

        .servicos-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }

        .servico-box {
            background: #1f2937;
            padding: 14px;
            border-radius: 14px;
            text-align: center;
            font-size: 13px;
            color: #d1d5db;
        }

        .servico-box span {
            display: block;
            font-size: 22px;
            margin-bottom: 8px;
        }

        .erro {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        @media(max-width: 768px) {
            .card {
                padding: 25px;
            }

            .topo h1 {
                font-size: 24px;
            }

            .servicos-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icone">🧾</div>
        <div class="topo">
            <h1>Pagar Serviços</h1>
            <p>Faça pagamentos de serviços diretamente pela sua conta Multicaixa Express.</p>
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
                        case "campos":
                            echo "Preencha todos os campos.";
                            break;
                        case "usuario":
                            echo "Utilizador não encontrado.";
                            break;
                        case "referencia":
                            echo "Número de referência inválido para este serviço.";
                            break;
                        case "servico":
                            echo "Serviço inválido.";
                            break;
                        default:
                            echo "Erro ao processar pagamento.";
                    }

                ?>

            </div>

        <?php endif; ?>

        <div class="servicos-grid">
            <div class="servico-box"><span>⚡</span>Energia</div>
            <div class="servico-box"><span>🌐</span>Internet</div>
            <div class="servico-box"><span>🚰</span>Água</div>
            <div class="servico-box"><span>📺</span>TV</div>
        </div>
        <form action="../actions/pagamento_action.php" method="POST">
            <div class="input-group">
                <label>Tipo de serviço</label>
                <select name="servico" required>
                    <option value="">Selecione</option>
                    <optgroup label="Energia">
                        <option value="energia|10001">ENDE — 10001</option>
                        <option value="energia|10002">Prodel — 10002</option>
                        <option value="energia|10003">RNT — 10003</option>
                    </optgroup>
                    <optgroup label="Internet">
                        <option value="internet|20001">Unitel — 20001</option>
                        <option value="internet|20002">Africell — 20002</option>
                        <option value="internet|20003">Movicel — 20003</option>
                    </optgroup>
                    <optgroup label="Água">
                        <option value="agua|30001">EPAL — 30001</option>
                        <option value="agua|30002">Aqua — 30002</option>
                        <option value="agua|30003">Pureza — 30003</option>
                    </optgroup>
                    <optgroup label="TV">
                        <option value="tv|40001">Zap — 40001</option>
                        <option value="tv|40002">DStv — 40002</option>
                        <option value="tv|40003">TV Cabo — 40003</option>
                    </optgroup>
                </select>
            </div>
            <div class="input-group">
                <label>Número da referência</label>
                <input type="text" name="referencia" placeholder="Ex: 123456789" required>
            </div>
            <div class="input-group">
                <label>Valor</label>
                <input type="number" name="valor" step="0.01" placeholder="0.00 Kz" required>
            </div>
            <button type="submit">Efetuar Pagamento</button>
        </form>

        <a href="dashboard.php" class="voltar">← Voltar ao Dashboard</a>

    </div>
</body>
</html>