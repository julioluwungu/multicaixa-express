<?php

require_once "database.php";

/* verificar se super admin já existe */
$sql = "SELECT id FROM usuarios WHERE email = 'admin@gmail.com'";
$stmt = $conn->prepare($sql);
$stmt->execute();

if (!$stmt->fetch()) {

    $senha = password_hash("Ha2rd0wa0re7", PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha, saldo, tipo)
            VALUES (?, ?, ?, 0, 'super_admin')";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        "Admin",
        "admin@gmail.com",
        $senha
    ]);
}