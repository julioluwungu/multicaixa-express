<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multicaixa Express</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .topbar {
            background: #111827;
            border-bottom: 1px solid rgba(254, 167, 52, 0.2);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h2 {
            color: #FEA734;
            font-size: 20px;
        }

        .menu {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .menu a {
            color: #FFFFFF;
            font-size: 14px;
            transition: 0.3s;
        }

        .menu a:hover {
            color: #FEA734;
        }

        .menu-toggle {
            display: none;
            font-size: 26px;
            cursor: pointer;
            color: #FEA734;
        }

        @media (max-width: 768px) {

            .menu {
                position: absolute;
                top: 60px;
                right: 0;
                background: #111827;
                flex-direction: column;
                width: 200px;
                padding: 15px;
                display: none;
                border-left: 1px solid rgba(254, 167, 52, 0.2);
                border-bottom: 1px solid rgba(254, 167, 52, 0.2);
            }

            .menu.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="container">
        <div class="logo"><h2>Multicaixa</h2></div>
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>

        <?php include "navbar.php"; ?>

    </div>
</header>

<main class="container">