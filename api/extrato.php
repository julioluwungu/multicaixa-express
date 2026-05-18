<?php

session_start();
require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode([]);
    exit;
}

$id = $_SESSION["id_usuario"];

$sql = "
    SELECT * FROM transacoes
    WHERE id_origem = ? OR id_destino = ?
    ORDER BY criado_em DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id, $id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));