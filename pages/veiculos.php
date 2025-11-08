<?php
include '../includes/auth.php';
include '../config/db.php';
requireAdmin();

$error = '';
$success = '';

// Cadastra ou edita veículo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_veiculo'])) {
    $id = $_POST['id'] ?? null;
    $placa = strtoupper(trim($_POST['placa'] ?? ''));
    $modelo = trim($_POST['modelo'] ?? '');
    $cor = trim($_POST['cor'] ?? '');
    $morador_id = $_POST['morador_id'] ?? null;
    $vaga_id = $_POST['vaga_id'] ?? null;
    
    if (empty($placa) || empty($modelo) || empty($morador_id)) {
        $error = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            if ($id) {
                // Editar
                $stmt = $pdo->prepare("UPDATE veiculos SET placa = ?, modelo = ?, cor = ?, morador_id = ?, vaga_id = ? WHERE id = ?");
                $stmt->execute([$placa, $modelo, $cor, $morador_id, $vaga_id ?: null, $id]);
                $success = 'Veículo atualizado com sucesso!';
            } else {
                // Cadastrar
                $stmt = $pdo->prepare("INSERT INTO veiculos (placa, modelo, cor, morador_id, vaga_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$placa, $modelo, $cor, $morador_id, $vaga_id ?: null]);
                $success = 'Veículo cadastrado com sucesso!';
            }
        } catch (PDOException $e) {
            $error = 'Erro ao salvar veículo.';
        }
    }
}

// Exclui veículo
if (isset($_GET['excluir'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM veiculos WHERE id = ?");
        $stmt->execute([$_GET['excluir']]);
        $success = 'Veículo excluído com sucesso!';
    } catch (PDOException $e) {
        $error = 'Erro ao excluir veículo.';
    }
}

// Lista veículos, moradores e vagas
try {
    $stmt = $pdo->query("SELECT v.*, u.nome as morador_nome, vg.numero as vaga_numero FROM veiculos v LEFT JOIN usuarios u ON v.morador_id = u.id LEFT JOIN vagas vg ON v.vaga_id = vg.id ORDER BY v.placa");
    $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("SELECT id, nome, apartamento FROM usuarios WHERE role = 'morador' ORDER BY nome");
    $moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("SELECT id, numero FROM vagas WHERE status = 'disponivel' ORDER BY numero");
    $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $veiculos = [];
    $moradores = [];
    $vagas = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Gerenciamento de Veículos</h1>
        
        <!-- Formulário de Cadastro de Veículo -->
        <!-- Campos: placa, modelo, cor, morador proprietário, vaga associada -->
        
        <!-- Tabela de Veículos -->
        <!-- Colunas: Placa, Modelo, Cor, Proprietário, Vaga, Ações (Editar/Excluir) -->
        
</main>

<?php include '../includes/footer.php'; ?>
