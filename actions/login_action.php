<?php

session_start();

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$email = trim($_POST["email"]);
$senha = trim($_POST["senha"]);

if (empty($email) || empty($senha)) {
    die("Preencha todos os campos.");
}

$sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Utilizador não encontrado.");
}

if (!password_verify($senha, $usuario["senha"])) {
    die("Senha incorreta.");
}

$_SESSION["id_usuario"] = $usuario["id"];
$_SESSION["nome_usuario"] = $usuario["nome"];

header("Location: ../public/dashboard.php");
exit;