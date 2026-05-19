<?php

require_once "../../includes/admin_auth.php";

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depósito Admin</title>
    <style>
        body {
            background: #050816;
            font-family: Arial;
            margin: 0;
            padding: 20px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: #111827;
            width: 100%;
            max-width: 450px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
        }

        h1 {
            color: #FEA734;
            margin-top: 0;
            margin-bottom: 10px;
        }

        p {
            color: #9ca3af;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #1f2937;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus {
            outline: 2px solid #FEA734;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #FEA734;
            border: none;
            border-radius: 12px;
            color: #050816;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .voltar {
            display: inline-block;
            margin-top: 20px;
            color: #FEA734;
            text-decoration: none;
        }

        .erro-box {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .sucesso-box {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
        }

    </style>
</head>
<body>
<div class="card">
    <h1>Depósito</h1>
    <?php if (isset($_GET["erro"])): ?>
        <div class="erro-box">
            <?php

            switch ($_GET["erro"]) {
                case "nao_encontrado":
                    echo "Usuário não encontrado.";
                    break;
                case "campos":
                    echo "Preencha os campos corretamente.";
                    break;
                default:
                    echo "Erro ao realizar depósito.";
            }

            ?>

        </div>

    <?php endif; ?>
    <?php if (isset($_GET["sucesso"])): ?>
        <div class="sucesso-box">Depósito realizado com sucesso.</div>
    <?php endif; ?>

    <p>Adicionar saldo a um usuário</p>

    <form action="../../actions/admin_depositar.php" method="POST">
        <div class="input-group">
            <label>Email do usuário</label>
            <input type="email" name="email" required>
        </div>
        <div class="input-group">
            <label>Valor</label>
            <input type="number" name="valor" step="0.01" required>
        </div>
        <button type="submit">Realizar Depósito</button>
    </form>

    <a href="index.php" class="voltar">← Voltar ao painel</a>
</div>
</body>
</html>