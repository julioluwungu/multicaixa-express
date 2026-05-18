<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/levantar.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];
$valor = floatval($_POST["valor"]);
$descricao = trim($_POST["descricao"]);

if ($valor <= 0) {
    die("Valor inválido.");
}

$conn->beginTransaction();

$sql = "SELECT saldo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Conta não encontrada.");
}

if ($usuario["saldo"] < $valor) {
    die("Saldo insuficiente.");
}

$sql = "UPDATE usuarios SET saldo = saldo - ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $id_usuario]);

$sql = "INSERT INTO transacoes (id_origem, id_destino, valor, descricao) VALUES (?, NULL, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario, $valor, $descricao]);

$conn->commit();

header("Location: ../public/dashboard.php");
exit;