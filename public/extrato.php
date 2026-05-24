<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extrato | Multicaixa Express</title>
    <link rel="shortcut icon" href="./assets/icones/favicon.ico" type="image/x-icon">
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
            font-size: 15px;
        }

        .acoes {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filtro-btn {
            background: #1f2937;
            border: none;
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        .filtro-btn:hover,
        .filtro-btn.active {
            background: #FEA734;
            color: #050816;
        }

        .lista {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .transacao {
            background: #111827;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.25);
            transition: 0.3s;
        }

        .transacao:hover {
            transform: translateY(-2px);
        }

        .left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icone {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 26px;
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
            margin-bottom: 6px;
            font-size: 18px;
        }

        .info p {
            color: #9ca3af;
            font-size: 14px;
            line-height: 1.5;
        }

        .valor {
            text-align: right;
        }

        .valor strong {
            display: block;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .valor span {
            font-size: 13px;
            color: #6b7280;
        }

        .entrada-texto {
            color: #22c55e;
        }

        .saida-texto {
            color: #ef4444;
        }

        .loading,
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

            .transacao {
                flex-direction: column;
                align-items: flex-start;
            }

            .valor {
                text-align: left;
                width: 100%;
            }

            .topo h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="topo">
        <h1>Extrato</h1>
        <p>Consulte o histórico das suas movimentações financeiras</p>
    </div>
    <div class="acoes">
        <button class="filtro-btn active" data-filtro="todos">Todos</button>
        <button class="filtro-btn" data-filtro="entrada">Entradas</button>
        <button class="filtro-btn" data-filtro="saida">Saídas</button>
    </div>
    <div class="lista" id="listaTransacoes">
        <div class="loading">Carregando extrato...</div>
    </div>
    <a href="dashboard.php" class="voltar">← Voltar ao Dashboard</a>
</div>

<script>

let transacoes = [];
async function carregarExtrato() {

    try {
        const resposta = await fetch("../api/extrato.php");
        const dados = await resposta.json();

        if (!dados.success) {
            document.getElementById("listaTransacoes").innerHTML = `<div class="vazio">Erro ao carregar extrato</div>`;
            return;
        }

        transacoes = dados.transacoes;
        renderizarTransacoes("todos");

    } catch (erro) {
        document.getElementById("listaTransacoes").innerHTML = `<div class="vazio">Erro de conexão</div>`;
    }
}

function renderizarTransacoes(filtro) {
    const lista = document.getElementById("listaTransacoes");
    let filtradas = transacoes;

    if (filtro !== "todos") {
        filtradas = transacoes.filter(t => t.tipo === filtro);
    }

    if (filtradas.length === 0) {
        lista.innerHTML = `<div class="vazio">Nenhuma transação encontrada</div>`;
        return;
    }

    lista.innerHTML = "";

    filtradas.forEach(transacao => {
        const icone = transacao.tipo === "entrada" ? "⬇" : "⬆";
        const classe = transacao.tipo === "entrada" ? "entrada" : "saida";
        const classeTexto = transacao.tipo === "entrada" ? "entrada-texto" : "saida-texto";

        lista.innerHTML += `
            <div class="transacao">
                <div class="left">
                    <div class="icone ${classe}">${icone}</div>
                    <div class="info">
                        <h3>${transacao.titulo}</h3>
                        <p>${transacao.usuario}</p>
                        <p>${transacao.descricao || ""}</p>
                    </div>
                </div>
                <div class="valor">
                    <strong class="${classeTexto}">
                        ${transacao.tipo === "entrada" ? "+" : "-"}
                        ${transacao.valor}
                    </strong>
                    <span>${transacao.data}</span>
                </div>
            </div>
        `;
    });
}

document.querySelectorAll(".filtro-btn").forEach(botao => {
    botao.addEventListener("click", () => {document.querySelectorAll(".filtro-btn").forEach(b => b.classList.remove("active"));
        botao.classList.add("active");
        renderizarTransacoes(botao.dataset.filtro);
    });
});

carregarExtrato();

</script>

</body>
</html>