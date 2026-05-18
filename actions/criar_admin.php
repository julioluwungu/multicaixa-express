<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";

$email = $_POST["email"];

$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

$sql = "UPDATE usuarios SET tipo = 'admin' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user["id"]]);

header("Location: ../public/admin/index.php");
exit;