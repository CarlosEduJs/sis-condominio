<?php
include '../includes/auth.php';
include '../config/db.php';
requireAdmin();

$error = '';
$success = '';

// Cadastra ou edita morador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_morador'])) {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome'] ?? '');
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $apartamento = trim($_POST['apartamento'] ?? '');
    $bloco = trim($_POST['bloco'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if (empty($nome) || empty($cpf) || empty($email) || empty($apartamento)) {
        $error = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            if ($id) {
                // Editar
                if (!empty($senha)) {
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, cpf = ?, email = ?, telefone = ?, apartamento = ?, bloco = ?, senha = ? WHERE id = ?");
                    $stmt->execute([$nome, $cpf, $email, $telefone, $apartamento, $bloco, $senha_hash, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, cpf = ?, email = ?, telefone = ?, apartamento = ?, bloco = ? WHERE id = ?");
                    $stmt->execute([$nome, $cpf, $email, $telefone, $apartamento, $bloco, $id]);
                }
                $success = 'Morador atualizado com sucesso!';
            } else {
                // Cadastrar
                if (empty($senha)) {
                    $error = 'Senha é obrigatória para novo morador.';
                } else {
                    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, cpf, email, telefone, apartamento, bloco, senha, role) VALUES (?, ?, ?, ?, ?, ?, ?, 'morador')");
                    $stmt->execute([$nome, $cpf, $email, $telefone, $apartamento, $bloco, $senha_hash]);
                    $success = 'Morador cadastrado com sucesso!';
                }
            }
        } catch (PDOException $e) {
            $error = 'Erro ao salvar morador. CPF pode já estar cadastrado.';
        }
    }
}

// Exclui morador
if (isset($_GET['excluir'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND role = 'morador'");
        $stmt->execute([$_GET['excluir']]);
        $success = 'Morador excluído com sucesso!';
    } catch (PDOException $e) {
        $error = 'Erro ao excluir morador.';
    }
}

// Lista moradores
try {
    $stmt = $pdo->query("SELECT * FROM usuarios WHERE role = 'morador' ORDER BY nome");
    $moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $moradores = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Gerenciamento de Moradores</h1>
        
        <!-- Formulário de Cadastro de Morador -->
        <!-- Campos: nome, cpf, email, telefone, apartamento, bloco, senha -->
        
        <!-- Tabela de Moradores -->
        <!-- Colunas: Nome, CPF, Apartamento, Bloco, Telefone, Ações (Editar/Excluir) -->
        
</main>

<?php include '../includes/footer.php'; ?>
