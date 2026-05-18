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
$servico = trim($_POST["servico"]);
$referencia = trim($_POST["referencia"]);
$valor = floatval($_POST["valor"]);

if ($valor <= 0) {
    die("Valor inválido.");
}

if (empty($servico) || empty($referencia)) {
    die("Preencha todos os campos.");
}

$conn->beginTransaction();

$sql = "SELECT saldo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Utilizador não encontrado.");
}

if ($usuario["saldo"] < $valor) {
    die("Saldo insuficiente.");
}

$sql = "UPDATE usuarios SET saldo = saldo - ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$valor, $id_usuario]);

$sql = "INSERT INTO pagamentos (id_usuario, servico, referencia, valor) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario, $servico, $referencia, $valor]);

$sql = "INSERT INTO transacoes (id_origem, id_destino, valor, descricao) VALUES (?, NULL, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario, $valor, "Pagamento: " . $servico]);

$conn->commit();

header("Location: ../public/dashboard.php");
exit;