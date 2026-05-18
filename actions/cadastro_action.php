<?php

session_start();

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/cadastro.php");
    exit;
}

$nome = trim($_POST["nome"]);
$email = trim($_POST["email"]);
$telefone = trim($_POST["telefone"]);
$senha = trim($_POST["senha"]);

if (empty($nome) || empty($email) || empty($senha)) {
    die("Preencha todos os campos obrigatórios.");
}

$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    die("Este email já está registado.");
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, telefone, senha, saldo) VALUES (?, ?, ?, ?, 0.00)";
$stmt = $conn->prepare($sql);
$stmt->execute([$nome, $email, $telefone, $senhaHash]);

$userId = $conn->lastInsertId();

$_SESSION["id_usuario"] = $userId;

header("Location: ../public/dashboard.php");
exit;