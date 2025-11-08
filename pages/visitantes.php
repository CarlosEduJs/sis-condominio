<?php
include '../includes/auth.php';
include '../config/db.php';

$error = '';
$success = '';

// Registra visitante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_visitante'])) {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
    $apartamento = trim($_POST['apartamento'] ?? '');
    $data_entrada = $_POST['data_entrada'] ?? date('Y-m-d H:i:s');
    
    if (empty($nome) || empty($cpf) || empty($apartamento)) {
        $error = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO visitantes (nome, cpf, apartamento_visitado, data_entrada) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $cpf, $apartamento, $data_entrada]);
            $success = 'Visitante registrado com sucesso!';
        } catch (PDOException $e) {
            $error = 'Erro ao registrar visitante.';
        }
    }
}

// Registra saída do visitante
if (isset($_GET['saida'])) {
    try {
        $stmt = $pdo->prepare("UPDATE visitantes SET data_saida = NOW() WHERE id = ?");
        $stmt->execute([$_GET['saida']]);
        $success = 'Saída registrada com sucesso!';
    } catch (PDOException $e) {
        $error = 'Erro ao registrar saída.';
    }
}

// Lista visitantes com filtros
$filtro_data = $_GET['data'] ?? '';
$filtro_apartamento = $_GET['apartamento'] ?? '';

try {
    $query = "SELECT * FROM visitantes WHERE 1=1";
    $params = [];
    
    if ($filtro_data) {
        $query .= " AND DATE(data_entrada) = ?";
        $params[] = $filtro_data;
    }
    
    if ($filtro_apartamento) {
        $query .= " AND apartamento_visitado = ?";
        $params[] = $filtro_apartamento;
    }
    
    $query .= " ORDER BY data_entrada DESC LIMIT 100";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $visitantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $visitantes = [];
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Registro de Visitantes</h1>
        
        <!-- Formulário de Registro de Visitante -->
        <!-- Campos: nome do visitante, cpf, apartamento visitado, data/hora entrada, data/hora saída -->
        
        <!-- Tabela de Visitantes -->
        <!-- Colunas: Nome, CPF, Apartamento, Data/Hora Entrada, Data/Hora Saída, Status -->
        <!-- Filtros: por data, por apartamento -->
        
</main>

<?php include '../includes/footer.php'; ?>
