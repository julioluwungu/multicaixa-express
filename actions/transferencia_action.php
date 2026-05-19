<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/transferir.php");
    exit;
}

$id_origem = $_SESSION["id_usuario"];
$email_destino = trim($_POST["email_destino"]);
$valor = floatval($_POST["valor"]);
$descricao = trim($_POST["descricao"]);

if ($valor <= 0) {
    header("Location: ../public/transferir.php?erro=valor");
    exit;
}

if (empty($email_destino)) {
    header("Location: ../public/transferir.php?erro=email");
    exit;
}

$conn->beginTransaction();

$sql = "
    SELECT id, saldo
    FROM usuarios
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_origem]);
$origem = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$origem) {
    header("Location: ../public/transferir.php?erro=origem");
    exit;
}

if ($origem["saldo"] < $valor) {
    header("Location: ../public/transferir.php?erro=saldo");
    exit;
}

$sql = "
    SELECT id, saldo
    FROM usuarios
    WHERE email = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$email_destino]);
$destino = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$destino) {
    header("Location: ../public/transferir.php?erro=destino");
    exit;
}

if ($destino["id"] == $id_origem) {
    header("Location: ../public/transferir.php?erro=proprio");
    exit;
}

$sql = "
    UPDATE usuarios
    SET saldo = saldo - ?
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $id_origem]);

$sql = "
    UPDATE usuarios
    SET saldo = saldo + ?
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $destino["id"]]);

$sql = "
    INSERT INTO transacoes
    (id_origem, id_destino, valor, descricao)
    VALUES (?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_origem, $destino["id"], $valor, $descricao]);
$conn->commit();

header("Location: ../public/dashboard.php?sucesso=transferencia");
exit;