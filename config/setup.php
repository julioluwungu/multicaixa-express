<?php

$host = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        CREATE DATABASE IF NOT EXISTS multicaixa_express
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci
    ";

    $conn->exec($sql);

} catch (PDOException $erro) {
    die("Erro ao criar banco: " . $erro->getMessage());
}