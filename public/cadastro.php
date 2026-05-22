<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Multicaixa Express</title>
    
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
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .erro {
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
            margin-top: 10px;
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
            display: block;
        }

        .btn:hover {
            transform: translateY(-3px);
            border-color: #F59E0B;
        }

        .btn-full {
            grid-column: 1 / -1;
        }

        .strength {
            font-size: 12px;
            margin-top: 8px;
        }

        .weak { color: #ef4444; }
        .medium { color: #f59e0b; }
        .strong { color: #22c55e; }

        .match {
            font-size: 12px;
            margin-top: 8px;
        }

        .match-success { color: #22c55e; }
        .match-error { color: #ef4444; }

        @media(max-width: 600px) {
            .card {
                padding: 25px 20px;
            }
            
            .titulo {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="logo"><img src="./assets/imagens/logo.png" alt="Logo do Multicaixa Express">Multicaixa Express</div>
</div>

<div class="container">
    <div class="card">
        <h1 class="titulo">CRIAR CONTA</h1>

        <?php if (isset($_GET["erro"])): ?>
            <div class="erro">
                <?php
                switch ($_GET["erro"]) {
                    case "senha_diferente":
                        echo "As senhas não coincidem.";
                        break;
                    case "email_existe":
                        echo "Este email já está registado.";
                        break;
                    case "senha_curta":
                        echo "A senha deve ter no mínimo 6 caracteres.";
                        break;
                    case "preencher":
                        echo "Preencha todos os campos obrigatórios.";
                        break;
                    default:
                        echo "Erro ao criar conta.";
                }
                ?>
            </div>
        <?php endif; ?>

        <form action="../actions/cadastro_action.php" method="POST">
            <div class="input-group">
                <label>Nome completo</label>
                <input type="text" name="nome" required placeholder="Digite seu nome completo">
            </div>
            
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="exemplo@email.com">
            </div>
            
            <div class="input-group">
                <label>Telefone (opcional)</label>
                <input type="text" name="telefone" placeholder="Digite seu telefone">
            </div>
            
            <div class="input-group">
                <label>Senha</label>
                <input type="password" name="senha" id="senha" required placeholder="Mínimo de 6 caracteres">
                <div id="forcaSenha" class="strength"></div>
            </div>
            
            <div class="input-group">
                <label>Confirmar Senha</label>
                <input type="password" name="confirmar_senha" id="confirmar" required placeholder="Digite a senha novamente">
                <div id="matchSenha" class="match"></div>
            </div>
            
            <button type="submit">Criar Conta</button>
        </form>

        <div class="acoes">
            <a href="login.php" class="btn btn-full">Voltar ao Login</a>
        </div>
    </div>
</div>

<script src="js/cadastro.js"></script>

<script>
    const senhaInput = document.getElementById('senha');
    const forcaDiv = document.getElementById('forcaSenha');
    
    senhaInput.addEventListener('input', function() {
        const senha = this.value;
        let forca = 0;
        
        if (senha.length >= 6) forca++;
        if (senha.length >= 10) forca++;
        if (/[A-Z]/.test(senha)) forca++;
        if (/[0-9]/.test(senha)) forca++;
        if (/[^A-Za-z0-9]/.test(senha)) forca++;
        
        let texto = '';
        let classe = '';
        
        if (senha.length === 0) {
            texto = '';
        } else if (forca <= 2) {
            texto = 'Senha fraca';
            classe = 'weak';
        } else if (forca <= 4) {
            texto = 'Senha média';
            classe = 'medium';
        } else {
            texto = 'Senha forte';
            classe = 'strong';
        }
        
        forcaDiv.textContent = texto;
        forcaDiv.className = 'strength ' + classe;
    });
    
    const confirmarInput = document.getElementById('confirmar');
    const matchDiv = document.getElementById('matchSenha');
    
    function verificarMatch() {
        const senha = senhaInput.value;
        const confirmar = confirmarInput.value;
        
        if (confirmar.length === 0) {
            matchDiv.textContent = '';
        } else if (senha === confirmar) {
            matchDiv.textContent = '✓ Senhas coincidem';
            matchDiv.className = 'match match-success';
        } else {
            matchDiv.textContent = '✗ As senhas não coincidem';
            matchDiv.className = 'match match-error';
        }
    }
    
    senhaInput.addEventListener('input', verificarMatch);
    confirmarInput.addEventListener('input', verificarMatch);
</script>

</body>
</html>