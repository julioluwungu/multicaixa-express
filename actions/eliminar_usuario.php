<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["tipo"]) || ($_SESSION["tipo"] !== "admin" && $_SESSION["tipo"] !== "super_admin")
) {
    header("Location: ../public/login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: ../public/admin/usuarios.php");
    exit;
}

$id = intval($_GET["id"]);

$sql = "SELECT tipo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: ../public/admin/usuarios.php");
    exit;
}

if ($usuario["tipo"] === "super_admin") {
    header("Location: ../public/admin/usuarios.php");
    exit;
}

if ($id == $_SESSION["id_usuario"]) {
    header("Location: ../public/admin/usuarios.php");
    exit;
}

$delete = "
    DELETE FROM usuarios
    WHERE id = ?
";

$stmt = $conn->prepare($delete);
$stmt->execute([$id]);

header("Location: ../public/admin/usuarios.php");
exit;