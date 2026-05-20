<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION["tipo"] !== "admin" && $_SESSION["tipo"] !== "super_admin") {
    header("Location: ../public/login.php");
    exit;
}