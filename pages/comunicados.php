<?php
include '../includes/auth.php';
include '../config/db.php';

$error = '';
$success = '';

// Cria comunicado (apenas admin)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['criar_comunicado']) && $_SESSION['role'] === 'admin') {
    $titulo = trim($_POST['titulo'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');
    
    if (empty($titulo) || empty($mensagem)) {
        $error = 'Preencha todos os campos.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO comunicados (titulo, mensagem, autor_id, data_publicacao) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$titulo, $mensagem, $_SESSION['user_id']]);
            $success = 'Comunicado publicado com sucesso!';
        } catch (PDOException $e) {
            $error = 'Erro ao publicar comunicado.';
        }
    }
}

// Exclui comunicado (apenas admin)
if (isset($_GET['excluir']) && $_SESSION['role'] === 'admin') {
    try {
        $stmt = $pdo->prepare("DELETE FROM comunicados WHERE id = ?");
        $stmt->execute([$_GET['excluir']]);
        $success = 'Comunicado excluído com sucesso!';
    } catch (PDOException $e) {
        $error = 'Erro ao excluir comunicado.';
    }
}

// Lista comunicados
try {
    $stmt = $pdo->query("SELECT c.*, u.nome as autor_nome FROM comunicados c LEFT JOIN usuarios u ON c.autor_id = u.id ORDER BY c.data_publicacao DESC");
    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $comunicados = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <div class="container">
        <h1>Comunicados</h1>
        
        <?php if($_SESSION['role'] === 'admin'): ?>
        <!-- Formulário de Novo Comunicado (apenas para admin) -->
        <!-- Campos: título, mensagem, data de publicação -->
        <?php endif; ?>
        
        <!-- Lista de Comunicados -->
        <!-- Exibir: título, data, mensagem completa ou resumida -->
        
    </div>
</main>

<?php include '../includes/footer.php'; ?>
