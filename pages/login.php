<?php
session_start();
include '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = preg_replace('/[^0-9]/', '', $_POST['username'] ?? '');
    $senha = $_POST['password'] ?? '';
    
    if (empty($cpf) || empty($senha)) {
        $error = 'Por favor, preencha todos os campos.';
    } else {
        try {
            
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = ? LIMIT 1");
            $stmt->execute([$cpf]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($senha, $user['senha'])) {
                // Login bem-sucedido
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nome'] = $user['nome'];  
                
                if ($user['role'] === 'admin') {
                    header("Location: dashboard-admin.php");
                } else {
                    header("Location: dashboard-morador.php");
                }
                exit;
            } else {
                $error = 'CPF ou senha inválidos.';
            }
        } catch (PDOException $e) {
            $error = 'Erro ao processar login. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Condomínio</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/forms.css">
</head>
<body>
    <main class="main-content login-page">
        <div class="container">
            <h1>Sistema de Gestão Condominial</h1>
            <p>Faça login para acessar o sistema</p>
            
            <div class="form-content">
                <?php if ($error): ?>
                    <div class="message-area error">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="message-area success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="login.php" novalidate>
                    <div class="form-group">
                        <label for="username">Seu CPF</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Sua Senha</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>
    </main>
    
    <footer class="main-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestão Condominial.</p>
        </div>
    </footer>
    
    <script src="../js/form-validation.js"></script>
</body>
</html>
