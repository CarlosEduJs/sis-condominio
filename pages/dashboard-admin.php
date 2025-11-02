<?php
include '../includes/auth.php';
include '../config/db.php';
requireAdmin();

// Busca estatísticas
try {
    // Total de moradores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE role = 'morador'");
    $total_moradores = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total de vagas e ocupadas
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM vagas");
    $total_vagas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as ocupadas FROM vagas WHERE status = 'ocupada'");
    $vagas_ocupadas = $stmt->fetch(PDO::FETCH_ASSOC)['ocupadas'];
    
    // Total de veículos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM veiculos");
    $total_veiculos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Visitantes hoje
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM visitantes WHERE DATE(data_entrada) = CURDATE()");
    $visitantes_hoje = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Últimos 5 comunicados
    $stmt = $pdo->query("SELECT * FROM comunicados ORDER BY data_publicacao DESC LIMIT 5");
    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $total_moradores = 0;
    $total_vagas = 0;
    $vagas_ocupadas = 0;
    $total_veiculos = 0;
    $visitantes_hoje = 0;
    $comunicados = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <div class="container">
        <h1>Dashboard - Administrador</h1>
        
        <!-- Área de Estatísticas -->
        <!-- Inserir cards com estatísticas: total de moradores, vagas ocupadas, veículos cadastrados, visitantes hoje -->
        
        <!-- Área de Ações Rápidas -->
        <!-- Inserir botões de acesso rápido para: moradores, vagas, veículos, visitantes, comunicados -->
        
        <!-- Área de Comunicados Recentes -->
        <!-- Listar últimos 5 comunicados publicados -->
        
    </div>
</main>

<?php include '../includes/footer.php'; ?>
