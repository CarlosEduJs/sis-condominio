<?php

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../pages/login.php");
    exit;
}

function requireAdmin() {
    if ($_SESSION['role'] !== 'admin') {
        header("Location: ../pages/dashboard-morador.php");
        exit;
    }
}

function requireMorador() {
    if ($_SESSION['role'] !== 'morador') {
        header("Location: ../pages/dashboard-admin.php");
        exit;
    }
}

?>