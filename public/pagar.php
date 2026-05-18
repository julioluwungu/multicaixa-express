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

        <div class="icone">
            🧾
        </div>

        <div class="topo">

            <h1>Pagar Serviços</h1>

            <p>
                Faça pagamentos de serviços diretamente
                pela sua conta Multicaixa Express.
            </p>

        </div>

        <div class="servicos-grid">

            <div class="servico-box">
                <span>⚡</span>
                Energia
            </div>

            <div class="servico-box">
                <span>🌐</span>
                Internet
            </div>

            <div class="servico-box">
                <span>🚰</span>
                Água
            </div>

            <div class="servico-box">
                <span>📺</span>
                TV
            </div>

        </div>

        <form action="../actions/pagamento_action.php" method="POST">

            <div class="input-group">

                <label>Tipo de serviço</label>

                <select name="servico" required>

                    <option value="">Selecione</option>

                    <option value="energia">
                        Energia
                    </option>

                    <option value="internet">
                        Internet
                    </option>

                    <option value="agua">
                        Água
                    </option>

                    <option value="tv">
                        TV
                    </option>

                </select>

            </div>

            <div class="input-group">

                <label>Número da referência</label>

                <input
                    type="text"
                    name="referencia"
                    placeholder="Ex: 123456789"
                    required
                >

            </div>

            <div class="input-group">

                <label>Valor</label>

                <input
                    type="number"
                    name="valor"
                    step="0.01"
                    placeholder="0.00 Kz"
                    required
                >

            </div>

            <button type="submit">
                Efetuar Pagamento
            </button>

        </form>

        <a href="dashboard.php" class="voltar">
            ← Voltar ao Dashboard
        </a>

    </div>

</body>
</html>