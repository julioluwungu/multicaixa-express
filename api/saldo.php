<?php

session_start();
require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode(["erro" => "não autenticado"]);
    exit;
}

$id = $_SESSION["id_usuario"];

$sql = "SELECT saldo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

echo json_encode([
    "saldo" => $stmt->fetchColumn()
]);