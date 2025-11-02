<?php
session_start();
include './config/db.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: ./pages/dashboard-admin.php");
        exit;
    } 
    
    if ($_SESSION['role'] === 'morador') {
        header("Location: ./pages/dashboard-morador.php");
        exit;
    }
}

// Se não estiver logado, redireciona para login
header("Location: ./pages/login.php");
exit;
?>