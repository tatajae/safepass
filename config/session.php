<?php

if (session_status() === PHP_SESSION_NONE) {

    ini_set('session.cookie_httponly', 1);

    session_start();
}

if (!isset($_SESSION['user_id'])) {

    header("Location: ../pages/login.php");
    exit;
}

$timeout = 300;

if (
    isset($_SESSION['LAST_ACTIVITY']) &&
    (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)
) {

    session_unset();

    session_destroy();

    header("Location: ../pages/login.php");

    exit;
}

$_SESSION['LAST_ACTIVITY'] = time();

session_regenerate_id(true);

?>