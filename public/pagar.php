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
            max-width: 750px;
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
            margin-bottom: 25px;
        }

        .subtitulo {
            text-align: center;
            color: #6B7280;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .erro {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.26);
            color: #B91C1C;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.4;
            animation: aparecer 0.25s ease;
        }

        .sucesso {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.26);
            color: #15803d;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
            animation: aparecer 0.25s ease;
            line-height: 1.4;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .servicos-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 18px 0 18px;
        }

        .servico-box {
            background: #fff;
            padding: 14px 10px;
            border-radius: 18px;
            border: 2px solid #E5E7EB;
            text-align: center;
            font-size: 13px;
            color: #6B7280;
            transition: 0.25s;
            min-height: 74px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .servico-box span {
            font-size: 22px;
            line-height: 1;
            margin: 0;
        }

        .servico-box:hover {
            transform: translateY(-3px);
            border-color: #F59E0B;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #6B7280;
            font-weight: bold;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 14px 14px;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            background: #fff;
            color: #111827;
            font-size: 16px;
            transition: 0.2s;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: 2px solid #F59E0B;
            border-color: #F59E0B;
        }

        button {
            width: 100%;
            border: none;
            padding: 16px;
            border-radius: 14px;
            background: #F59E0B;
            color: #050816;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            opacity: 0.92;
            transform: translateY(-1px);
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

        @media(max-width: 700px) {
            .titulo { font-size: 28px; }
            .container { padding: 16px; }
            .card { padding: 22px 14px; }
            .servicos-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        }
    </style>
</head>

<body>
<div class="topbar">
    <div class="logo">Multicaixa Express</div>
</div>

<div class="container">
    <div class="card">
        <h1 class="titulo">PAGAR SERVIÇOS</h1>

        <p class="subtitulo">Faça pagamentos de serviços diretamente pela sua conta Multicaixa Express.</p>

        <?php if (isset($_GET["sucesso"])): ?>
            <div class="sucesso">✓ Pagamento realizado com sucesso!</div>
        <?php endif; ?>

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

        <div class="acoes">
            <a href="dashboard.php" class="btn voltar-btn">Voltar</a>
        </div>
    </div>
</div>

</body>
</html>