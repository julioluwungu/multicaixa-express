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
$senha = $_POST["senha"];
$confirmar = $_POST["confirmar_senha"];

if ($senha !== $confirmar) {
    header("Location: ../public/cadastro.php?erro=senha_diferente");
    exit;
}

$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

if ($stmt->fetch()) {
    header("Location: ../public/cadastro.php?erro=email_existe");
    exit;
}

/* segurança extra nível banco */
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, telefone, senha, saldo)
        VALUES (?, ?, ?, ?, 0)";

$stmt = $conn->prepare($sql);
$stmt->execute([$nome, $email, $telefone, $senha_hash]);

header("Location: ../public/login.php?sucesso=conta_criada");
exit;