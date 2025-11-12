<?php
include_once '../includes/auth.php';
include_once '../config/db.php';
requireMorador();

// Busca dados do morador
try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $morador = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Veículos do morador
    $stmt = $pdo->prepare("SELECT * FROM veiculos WHERE morador_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Vagas do morador
    $stmt = $pdo->prepare("SELECT * FROM vagas WHERE morador_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Visitantes recentes
    $stmt = $pdo->prepare("SELECT * FROM visitantes WHERE apartamento_visitado = ? ORDER BY data_entrada DESC LIMIT 10");
    $stmt->execute([$morador['apartamento']]);
    $visitantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Comunicados recentes
    $stmt = $pdo->query("SELECT * FROM comunicados ORDER BY data_publicacao DESC LIMIT 5");
    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $morador = [];
    $veiculos = [];
    $vagas = [];
    $visitantes = [];
    $comunicados = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Dashboard - Morador</h1>
    
</main>

<?php include '../includes/footer.php'; ?>
