<?php

require_once __DIR__ . '/setup.php';

$host = "localhost";
$dbname = "multicaixa_express";
$username = "root";
$password = "";

try {

    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $erro) {

    die("Erro na conexão: " . $erro->getMessage());

}

require_once __DIR__ . '/migrations.php';