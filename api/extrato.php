<?php

session_start();

require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_SESSION["id_usuario"])) {

    echo json_encode([
        "success" => false,
        "message" => "Usuário não autenticado"
    ]);

    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$sql = "

    SELECT
        t.id,
        t.id_origem,
        t.id_destino,
        t.valor,
        t.descricao,
        t.criado_em,

        uo.nome AS nome_origem,
        ud.nome AS nome_destino

    FROM transacoes t

    LEFT JOIN usuarios uo
        ON uo.id = t.id_origem

    LEFT JOIN usuarios ud
        ON ud.id = t.id_destino

    WHERE t.id_origem = ?
    OR t.id_destino = ?

    ORDER BY t.criado_em DESC

";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $id_usuario,
    $id_usuario
]);

$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resultado = [];

foreach ($transacoes as $t) {

    $tipo = "";

    if ($t["id_origem"] == $id_usuario) {

        $tipo = "saida";

        $titulo = "Transferência enviada";

        $usuario_relacionado = $t["nome_destino"];

    } else {

        $tipo = "entrada";

        $titulo = "Transferência recebida";

        $usuario_relacionado = $t["nome_origem"];
    }

    $resultado[] = [

        "id" => $t["id"],

        "tipo" => $tipo,

        "titulo" => $titulo,

        "usuario" => $usuario_relacionado,

        "valor" => number_format(
            $t["valor"],
            2,
            ",",
            "."
        ) . " Kz",

        "valor_bruto" => $t["valor"],

        "descricao" => $t["descricao"],

        "data" => date(
            "d/m/Y H:i",
            strtotime($t["criado_em"])
        )

    ];
}

echo json_encode([
    "success" => true,
    "transacoes" => $resultado
]);