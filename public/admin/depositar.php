<?php

require_once "../../includes/admin_auth.php";

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depósito | Admin | Multicaixa Express</title>
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
            max-width: 500px;
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
            margin-bottom: 25px;
        }

        .erro-box {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.26);
            color: #B91C1C;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: aparecer 0.25s ease;
            line-height: 1.4;
        }

        .sucesso-box {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.26);
            color: #15803d;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: aparecer 0.25s ease;
            line-height: 1.4;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #6B7280;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 14px 14px;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            background: #fff;
            color: #111827;
            font-size: 16px;
            transition: 0.2s;
        }

        .input-group input:focus {
            outline: 2px solid #F59E0B;
            border-color: #F59E0B;
        }

        button {
            width: 100%;
            border: none;
            padding: 16px;
            border-radius: 14px;
            background: #F59E0B;
            color: #ffffff;
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

        @media(max-width: 600px) {
            .card {
                padding: 25px 20px;
            }
            
            .titulo {
                font-size: 28px;
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
        <h1 class="titulo">DEPÓSITO</h1>
        <p class="subtitulo">Adicionar saldo a um usuário</p>

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
            <div class="sucesso-box">✓ Depósito realizado com sucesso.</div>
        <?php endif; ?>

        <form action="../../actions/admin_depositar.php" method="POST">
            <div class="input-group">
                <label>Email do usuário</label>
                <input type="email" name="email" placeholder="exemplo@email.com" required>
            </div>
            
            <div class="input-group">
                <label>Valor</label>
                <input type="number" name="valor" step="0.01" placeholder="0.00 Kz" required>
            </div>
            
            <button type="submit">Realizar Depósito</button>
        </form>

        <div class="acoes">
            <a href="index.php" class="btn-voltar voltar-btn">
                Voltar
            </a>
        </div>
    </div>
</div>
</body>
</html>