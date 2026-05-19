<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";

$email = trim($_POST["email"]);
$valor = floatval($_POST["valor"]);

if (empty($email) || $valor <= 0) {
    header("Location: ../public/admin/depositar.php?erro=campos");
    exit;
}

$sql = "
    SELECT id
    FROM usuarios
    WHERE email = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: ../public/admin/depositar.php?erro=nao_encontrado");
    exit;
}

$conn->beginTransaction();

$stmt = $conn->prepare("
    UPDATE usuarios
    SET saldo = saldo + ?
    WHERE id = ?
");

$stmt->execute([
    $valor,
    $user["id"]
]);

$stmt = $conn->prepare("
    INSERT INTO movimentos (id_usuario, tipo, valor, descricao)
    VALUES (?, 'deposito', ?, 'Depósito administrativo')
");

$stmt->execute([$user["id"], $valor]);
$conn->commit();

header("Location: ../public/admin/depositar.php?sucesso=1");
exit;