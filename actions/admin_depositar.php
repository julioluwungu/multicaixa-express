<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";

$email = $_POST["email"];
$valor = floatval($_POST["valor"]);

$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

$conn->beginTransaction();

/* saldo */
$stmt = $conn->prepare("UPDATE usuarios SET saldo = saldo + ? WHERE id = ?");
$stmt->execute([$valor, $user["id"]]);

/* movimento */
$stmt = $conn->prepare("
    INSERT INTO movimentos (id_usuario, tipo, valor, descricao)
    VALUES (?, 'deposito', ?, 'Depósito admin')
");
$stmt->execute([$user["id"], $valor]);

$conn->commit();

header("Location: ../public/admin/index.php");
exit;