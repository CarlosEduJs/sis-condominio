<?php
include_once '../includes/auth.php';
include_once '../config/db.php';

    try {
        // obter o nome do usuario logado

        $stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $user = ['nome' => 'Usuário'];
    }

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão Condominial</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dashboard.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="../js/main.js"></script>

</head>
<body>
    <header class="main-header">
        <h1 class="logo">Sis. Condomínio</h1>
                <?php if(isset($_SESSION['user_id'])): ?>
                <nav class="main-nav">
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <a class="link" href="dashboard-admin.php"><span class="material-symbols-outlined">dashboard</span> Dashboard</a>
                        <a class="link" href="moradores.php"><span class="material-symbols-outlined">people</span> Moradores</a>
                        <a class="link" href="vagas.php"><span class="material-symbols-outlined">local_parking</span> Vagas</a>
                        <a class="link" href="veiculos.php"><span class="material-symbols-outlined">directions_car</span> Veículos</a>
                        <a class="link" href="visitantes.php"><span class="material-symbols-outlined">person_add</span> Visitantes</a>
                        <a class="link" href="comunicados.php"><span class="material-symbols-outlined">announcement</span> Comunicados</a>
                    <?php else: ?>
                        <a class="link" href="dashboard-morador.php"><span class="material-symbols-outlined">dashboard</span> Dashboard</a>
                        <a class="link" href="comunicados.php"><span class="material-symbols-outlined">announcement</span> Comunicados</a>
                        <a class="link" href="visitantes.php"><span class="material-symbols-outlined">person_add</span> Visitantes</a>
                    <?php endif; ?>
                    <a class="link" href="perfil.php"><span class="material-symbols-outlined">person</span> Perfil</a>
                    <a href="logout.php" class="btn btn-logout btn-sm">Sair da conta</a>
                </nav>
                <div class="menu">
                    <span class="material-symbols-outlined menu-icon" onclick="toggleMenu()">
                        density_medium
                    </span>
                    <div class="menu-content">
                        <p class="user-greeting">Olá, <?php echo htmlspecialchars($user['nome']); ?>!</p>
                        <nav class="main-nav-mobile">
                            <?php if($_SESSION['role'] === 'admin'): ?>
                                <a class="link" href="dashboard-admin.php">Dashboard <span class="material-symbols-outlined">dashboard</span></a>
                                <a class="link" href="moradores.php">Moradores <span class="material-symbols-outlined">people</span></a>
                                <a class="link" href="vagas.php">Vagas <span class="material-symbols-outlined">local_parking</span></a>
                                <a class="link" href="veiculos.php">Veículos <span class="material-symbols-outlined">directions_car</span></a>
                                <a class="link" href="visitantes.php">Visitantes <span class="material-symbols-outlined">person_add</span></a>
                                <a class="link" href="comunicados.php">Comunicados <span class="material-symbols-outlined">announcement</span></a>
                            <?php else: ?>
                                <a class="link" href="dashboard-morador.php">Dashboard <span class="material-symbols-outlined">dashboard</span></a>
                                <a class="link" href="comunicados.php">Comunicados <span class="material-symbols-outlined">announcement</span></a>
                                <a class="link" href="visitantes.php">Visitantes <span class="material-symbols-outlined">person_add</span></a>
                            <?php endif; ?>
                            <a class="link" href="perfil.php">Perfil <span class="material-symbols-outlined">person</span></a>
                        </nav>
                        <a href="logout.php" class="btn btn-logout">Sair da conta <span class="material-symbols-outlined">logout</span></a>
                    </div>
                </div>

                <div class="portal-menu"></div>
                <?php endif; ?>
    </header>
