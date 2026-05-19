<?php

session_start();

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$email = trim($_POST["email"]);
$senha = trim($_POST["senha"]);
$modo = $_POST["modo"] ?? "user";

if (empty($email) || empty($senha)) {
    header("Location: ../public/login.php?erro=preencher");
    exit;
}

$sql = "
    SELECT id, nome, email, senha, tipo
    FROM usuarios
    WHERE email = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: ../public/login.php?erro=nao_encontrado");
    exit;
}

if (!password_verify($senha, $usuario["senha"])) {
    header("Location: ../public/login.php?erro=senha_incorreta");
    exit;
}

if ($modo === "admin") {
    if ($usuario["tipo"] !== "admin" && $usuario["tipo"] !== "super_admin") {
        header("Location: ../public/login.php?modo=admin&erro=sem_permissao");
        exit;
    }

}

if ($modo === "user") {
    if ($usuario["tipo"] === "admin" || $usuario["tipo"] === "super_admin") {
        header("Location: ../public/login.php?modo=user&erro=admin_nao");
        exit;
    }
}

$_SESSION["id_usuario"] = $usuario["id"];
$_SESSION["nome_usuario"] = $usuario["nome"];
$_SESSION["tipo"] = $usuario["tipo"];

if ($usuario["tipo"] === "admin" || $usuario["tipo"] === "super_admin") {
    header("Location: ../public/admin/index.php");
    exit;
}

header("Location: ../public/dashboard.php");
exit;