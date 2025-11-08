<?php
include '../includes/auth.php';
include '../config/db.php';

$error = '';
$success = '';

// Busca dados do usuário
try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Erro ao carregar dados do perfil.';
}

// Atualiza dados pessoais
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_dados'])) {
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    
    if (empty($email) || empty($telefone)) {
        $error = 'Preencha todos os campos.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET email = ?, telefone = ? WHERE id = ?");
            $stmt->execute([$email, $telefone, $_SESSION['user_id']]);
            $success = 'Dados atualizados com sucesso!';
            
            // Atualiza os dados do usuário
            $user['email'] = $email;
            $user['telefone'] = $telefone;
        } catch (PDOException $e) {
            $error = 'Erro ao atualizar dados.';
        }
    }
}

// Altera senha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_senha'])) {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
        $error = 'Preencha todos os campos de senha.';
    } elseif ($nova_senha !== $confirmar_senha) {
        $error = 'As senhas não coincidem.';
    } elseif (strlen($nova_senha) < 8) {
        $error = 'A nova senha deve ter no mínimo 8 caracteres.';
    } else {
        if (password_verify($senha_atual, $user['senha'])) {
            try {
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
                $stmt->execute([$nova_senha_hash, $_SESSION['user_id']]);
                $success = 'Senha alterada com sucesso!';
            } catch (PDOException $e) {
                $error = 'Erro ao alterar senha.';
            }
        } else {
            $error = 'Senha atual incorreta.';
        }
    }
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Meu Perfil</h1>
        
        <!-- Informações do Usuário -->
        <!-- Exibir: nome, cpf, email, telefone, apartamento (se morador) -->
        
        <!-- Formulário de Alteração de Senha -->
        <!-- Campos: senha atual, nova senha, confirmar nova senha -->
        
        <!-- Formulário de Atualização de Dados -->
        <!-- Campos editáveis: email, telefone -->
</main>

<?php include '../includes/footer.php'; ?>
