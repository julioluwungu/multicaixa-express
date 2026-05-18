<?php

session_start();
require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode(["erro" => "não autenticado"]);
    exit;
}

$id_origem = $_SESSION["id_usuario"];
$email_destino = $_POST["email_destino"] ?? null;
$valor = floatval($_POST["valor"] ?? 0);

if (!$email_destino || $valor <= 0) {
    echo json_encode(["erro" => "dados inválidos"]);
    exit;
}

$conn->beginTransaction();

$sql = "SELECT id, saldo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_origem]);
$origem = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email_destino]);
$destino = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$destino || $origem["saldo"] < $valor) {
    echo json_encode(["erro" => "transferência inválida"]);
    exit;
}

$sql = "UPDATE usuarios SET saldo = saldo - ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $id_origem]);

$sql = "UPDATE usuarios SET saldo = saldo + ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $destino["id"]]);

$sql = "INSERT INTO transacoes (id_origem, id_destino, valor, descricao)
        VALUES (?, ?, ?, 'Transferência API')";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_origem, $destino["id"], $valor]);

$conn->commit();

echo json_encode(["sucesso" => true]);