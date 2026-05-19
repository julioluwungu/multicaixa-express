<?php

session_start();
session_unset();
$_SESSION = [];
session_destroy();

header("Location: ../public/login.php");
exit;