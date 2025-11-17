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
    <h1>Olá, <?php echo htmlspecialchars($morador['nome'] ?? 'Morador'); ?>!</h1>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <header>
                <h2>Meus Veículos</h2>
                <div class="right">
                    <button class="btn btn-sm btn-outline" onclick="location.href='veiculos.php'">Gerenciar Veículos</button>
                </div>
            </header>
            <div class="group-value">
                <p class="value"><?php echo count($veiculos); ?></p>
                <p class="muted">veículo(s) registrados</p>
            </div>
            <?php if(!empty($veiculos)): ?>
                <span class="card-badge"><?php echo htmlspecialchars($veiculos[0]['placa']); ?><?php echo (count($veiculos) > 1 ? ' +'.(count($veiculos)-1) : ''); ?></span>
            <?php endif; ?>
        </div>

        <div class="dashboard-card">
            <header>
                <h2>Minhas Vagas</h2>
                <div class="right">
                    <button class="btn btn-sm btn-outline" onclick="location.href='vagas.php'">Ver Vagas</button>
                </div>
            </header>
            <div class="group-value">
                <p class="value"><?php echo count($vagas); ?></p>
                <p class="muted">vaga(s) atribuída(s)</p>
            </div>
            <?php if(!empty($vagas)): ?>
                <span class="card-badge card-badge-success"><?php echo htmlspecialchars($vagas[0]['numero'] ?? 'N/A'); ?></span>
            <?php endif; ?>
        </div>

        <div class="dashboard-card">
            <header>
                <h2>Visitantes Recentes</h2>
                <div class="right">
                    <button class="btn btn-sm btn-outline" onclick="location.href='visitantes.php'">Ver Visitantes</button>
                </div>
            </header>
            <div class="group-value">
                <p class="value"><?php echo count($visitantes); ?></p>
                <p class="muted">últimos visitantes</p>
            </div>
        </div>
    </div>

    <div class="dashboard-sections">
        <section class="dashboard-section">
            <header>
                <h2>📢 Comunicados Recentes</h2>
                <button onclick="location.href='comunicados.php'" class="btn btn-sm btn-outline">Ver todos</button>
            </header>
            <div class="section-content">
                <?php if(empty($comunicados)): ?>
                    <p class="muted">Nenhum comunicado publicado ainda.</p>
                <?php else: ?>
                    <ul class="list-items">
                        <?php foreach($comunicados as $com): ?>
                            <li class="list-item">
                                <div>
                                    <strong><?php echo htmlspecialchars($com['titulo']); ?></strong>
                                    <p class="muted"><?php echo htmlspecialchars(mb_strimwidth($com['mensagem'], 0, 100, '...')); ?></p>
                                    <small class="muted"><?php echo date('d/m/Y H:i', strtotime($com['data_publicacao'])); ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <section class="dashboard-section">
            <header>
                <h2>👥 Visitantes do Seu Apto</h2>
                <button onclick="location.href='visitantes.php'" class="btn btn-sm btn-outline">Gerenciar</button>
            </header>
            <div class="section-content">
                <?php if(empty($visitantes)): ?>
                    <p class="muted">Nenhum visitante recente para o seu apartamento.</p>
                <?php else: ?>
                    <ul class="list-items">
                        <?php foreach($visitantes as $vis): ?>
                            <li class="list-item">
                                <span class="material-symbols-outlined">person</span>
                                <div>
                                    <strong><?php echo htmlspecialchars($vis['nome']); ?></strong>
                                    <p class="muted">Motivo: <?php echo htmlspecialchars($vis['motivo'] ?? '—'); ?></p>
                                    <small class="muted">Entrada: <?php echo date('d/m/Y H:i', strtotime($vis['data_entrada'])); ?><?php if(!empty($vis['data_saida'])) echo ' — Saída: '.date('d/m/Y H:i', strtotime($vis['data_saida'])); ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <section class="dashboard-section">
            <header>
                <h2>🚗 Meus Veículos</h2>
                <button onclick="location.href='veiculos.php'" class="btn btn-sm btn-outline">Gerenciar</button>
            </header>
            <div class="section-content">
                <?php if(empty($veiculos)): ?>
                    <p class="muted">Nenhum veículo cadastrado.</p>
                <?php else: ?>
                    <ul class="list-items">
                        <?php foreach($veiculos as $v): ?>
                            <li class="list-item">
                                <span class="material-symbols-outlined">directions_car</span>
                                <div>
                                    <strong><?php echo htmlspecialchars($v['placa']); ?> — <?php echo htmlspecialchars($v['modelo'] ?? 'Modelo não informado'); ?></strong>
                                    <p class="muted"><?php echo htmlspecialchars($v['cor'] ?? 'Cor não informada'); ?></p>
                                    <small class="muted">Registrado em: <?php echo date('d/m/Y', strtotime($v['created_at'] ?? date('Y-m-d'))); ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
