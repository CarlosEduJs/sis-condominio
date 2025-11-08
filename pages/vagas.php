<?php
include '../includes/auth.php';
include '../config/db.php';
requireAdmin();

$error = '';
$success = '';

// Cadastra ou edita vaga
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_vaga'])) {
    $id = $_POST['id'] ?? null;
    $numero = trim($_POST['numero'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $status = $_POST['status'] ?? 'disponivel';
    $morador_id = $_POST['morador_id'] ?? null;
    
    if (empty($numero) || empty($tipo)) {
        $error = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            if ($id) {
                // Editar
                $stmt = $pdo->prepare("UPDATE vagas SET numero = ?, tipo = ?, status = ?, morador_id = ? WHERE id = ?");
                $stmt->execute([$numero, $tipo, $status, $morador_id ?: null, $id]);
                $success = 'Vaga atualizada com sucesso!';
            } else {
                // Cadastrar
                $stmt = $pdo->prepare("INSERT INTO vagas (numero, tipo, status, morador_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$numero, $tipo, $status, $morador_id ?: null]);
                $success = 'Vaga cadastrada com sucesso!';
            }
        } catch (PDOException $e) {
            $error = 'Erro ao salvar vaga.';
        }
    }
}

// Exclui vaga
if (isset($_GET['excluir'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM vagas WHERE id = ?");
        $stmt->execute([$_GET['excluir']]);
        $success = 'Vaga excluída com sucesso!';
    } catch (PDOException $e) {
        $error = 'Erro ao excluir vaga.';
    }
}

// Lista vagas e moradores
try {
    $stmt = $pdo->query("SELECT v.*, u.nome as morador_nome FROM vagas v LEFT JOIN usuarios u ON v.morador_id = u.id ORDER BY v.numero");
    $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("SELECT id, nome, apartamento FROM usuarios WHERE role = 'morador' ORDER BY nome");
    $moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $vagas = [];
    $moradores = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Gerenciamento de Vagas</h1>
        
        <!-- Formulário de Cadastro de Vaga -->
        <!-- Campos: número da vaga, tipo (coberta/descoberta), status (disponível/ocupada), morador responsável -->
        
        <!-- Tabela de Vagas -->
        <!-- Colunas: Número, Tipo, Status, Morador, Ações (Editar/Excluir) -->
</main>

<?php include '../includes/footer.php'; ?>
