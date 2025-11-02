<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão Condominial</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <h1 class="logo">Sistema Condomínio</h1>
                <?php if(isset($_SESSION['user_id'])): ?>
                <nav class="main-nav">
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <a href="dashboard-admin.php">Dashboard</a>
                        <a href="moradores.php">Moradores</a>
                        <a href="vagas.php">Vagas</a>
                        <a href="veiculos.php">Veículos</a>
                        <a href="visitantes.php">Visitantes</a>
                        <a href="comunicados.php">Comunicados</a>
                    <?php else: ?>
                        <a href="dashboard-morador.php">Dashboard</a>
                        <a href="comunicados.php">Comunicados</a>
                        <a href="visitantes.php">Visitantes</a>
                    <?php endif; ?>
                    <a href="perfil.php">Perfil</a>
                    <a href="logout.php" class="btn-logout">Sair</a>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </header>
