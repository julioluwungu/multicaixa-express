<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {

    header("Location: ../public/login.php");
    exit;

}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../public/pagar.php");
    exit;

}

$id_usuario = $_SESSION["id_usuario"];

/* serviço selecionado */

$servicoCompleto = trim($_POST["servico"]);

$referencia = trim($_POST["referencia"]);

$valor = floatval($_POST["valor"]);

/* validar serviço */

$partes = explode("|", $servicoCompleto);

if (count($partes) != 2) {

    header("Location: ../public/pagar.php?erro=servico");
    exit;

}

$servico = $partes[0];

$referenciaValida = $partes[1];

/* validações */

if ($valor <= 0) {

    header("Location: ../public/pagar.php?erro=valor");
    exit;

}

if (empty($servico) || empty($referencia)) {

    header("Location: ../public/pagar.php?erro=campos");
    exit;

}

/* validar referência */

if ($referencia !== $referenciaValida) {

    header("Location: ../public/pagar.php?erro=referencia");
    exit;

}

$conn->beginTransaction();

/* buscar utilizador */

$sql = "
    SELECT saldo
    FROM usuarios
    WHERE id = ?
";

$stmt = $conn->prepare($sql);

$stmt->execute([$id_usuario]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {

    header("Location: ../public/pagar.php?erro=usuario");
    exit;

}

/* validar saldo */

if ($usuario["saldo"] < $valor) {

    header("Location: ../public/pagar.php?erro=saldo");
    exit;

}

/* descontar saldo */

$sql = "
    UPDATE usuarios
    SET saldo = saldo - ?
    WHERE id = ?
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $valor,
    $id_usuario
]);

/* guardar pagamento */

$sql = "
    INSERT INTO pagamentos
    (id_usuario, servico, referencia, valor)
    VALUES (?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $id_usuario,
    $servico,
    $referencia,
    $valor
]);

/* guardar transação */

$sql = "
    INSERT INTO transacoes
    (id_origem, id_destino, valor, descricao)
    VALUES (?, NULL, ?, ?)
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $id_usuario,
    $valor,
    "Pagamento: " . ucfirst($servico)
]);

$conn->commit();

header("Location: ../public/dashboard.php?sucesso=pagamento");

exit;