<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../public/login.php");
    exit;
}

$id = $_SESSION["id_usuario"];
$valor = floatval($_POST["valor"]);
$descricao = trim($_POST["descricao"]);

if ($valor <= 0) {
    die("Valor inválido.");
}

$conn->beginTransaction();

/* atualizar saldo */
$sql = "UPDATE usuarios SET saldo = saldo + ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $id]);

/* registar movimento */
$sql = "INSERT INTO movimentos (id_usuario, tipo, valor, descricao)
        VALUES (?, 'deposito', ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id, $valor, $descricao]);

$conn->commit();

header("Location: ../public/dashboard.php");
exit;