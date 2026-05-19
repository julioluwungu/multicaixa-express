<?php

require_once __DIR__ . '/setup.php';

$isLocal = $_SERVER['SERVER_NAME'] === 'localhost';

$localConfig = [
    "host" => "localhost",
    "dbname" => "multicaixa_express",
    "user" => "root",
    "pass" => ""
];

$prodConfig = [
    "host" => "",
    "dbname" => "",
    "user" => "",
    "pass" => ""
];

$config = $isLocal ? $localConfig : $prodConfig;

$host = $config['host'];
$dbname = $config['dbname'];
$user = $config['user'];
$pass = $config['pass'];

try {
    if ($isLocal) {
        $conn = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $conn->exec("USE $dbname");
    } else {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    require_once __DIR__ . '/migrations.php';
    require_once __DIR__ . '/bootstrap.php';

} catch (PDOException $erro) {
    die("Erro na conexão: " . $erro->getMessage());
}