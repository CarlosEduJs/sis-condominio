<?php
include_once '../includes/auth.php';
include_once '../config/db.php';
requireAdmin();

// Busca estatísticas
try {
    // pegar o administrador logado
    $stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $stmt = $pdo->query("SELECT c.*, u.nome as autor_nome FROM comunicados c 
                        LEFT JOIN usuarios u ON c.autor_id = u.id 
                        ORDER BY c.data_publicacao DESC LIMIT 5");
    $comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Visitantes ativos (ainda não saíram)
    $stmt = $pdo->query("SELECT * FROM visitantes 
                        WHERE data_saida IS NULL 
                        ORDER BY data_entrada DESC LIMIT 5");
    $visitantes_ativos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Últimas atividades
    $stmt = $pdo->query("SELECT nome, created_at, 'morador' as tipo FROM usuarios 
                        WHERE role = 'morador' 
                        ORDER BY created_at DESC LIMIT 5");
    $ultimos_moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("SELECT v.*, u.nome as morador_nome FROM veiculos v
                        LEFT JOIN usuarios u ON v.morador_id = u.id
                        ORDER BY v.created_at DESC LIMIT 5");
    $ultimos_veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // pegar o numero de 'ultimos usuarios' cadastrados em poucas horas

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE role = 'morador' AND created_at >= NOW() - INTERVAL 1 HOUR"); // pegar somente moradores cadastrados na ultima hora
    $ultimos_moradores_em_poucas_horas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    $total_moradores = 0;
    $total_vagas = 0;
    $vagas_ocupadas = 0;
    $total_veiculos = 0;
    $visitantes_hoje = 0;
    $comunicados = [];
    $visitantes_ativos = [];
    $ultimos_moradores = [];
    $ultimos_veiculos = [];
    $ultimos_moradores_em_poucas_horas = 0;
}
?>
<?php include '../includes/header.php'; ?>

<main class="main-content">
    <h1>Olá, <?php echo htmlspecialchars($admin['nome']); ?>!</h1>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <header>
                <h2>Moradores</h2>
                <div class="right">
                    <button class="btn btn-sm btn-outline" onclick="location.href='moradores.php'">Gerenciar Moradores</button>
                </div>
            </header>
            <div class="group-value">
                <p class="value"><?php echo $total_moradores; ?></p>
                <p class="muted">morador(es) registrados</p>
            </div>

            <?php if($ultimos_moradores_em_poucas_horas > 0): ?>
                <span class="card-badge card-badge-success"><?php echo $ultimos_moradores_em_poucas_horas; ?> novo(s) morador(es) registrado(s) nas últimas horas</span>
            <?php endif; ?>
        </div>
        <div class="dashboard-card">
            <header>
                <h2>Vagas</h2>
                <div class="right">
                    <button class="btn btn-sm btn-outline" onclick="location.href='vagas.php'">Gerenciar Vagas</button>
                </div>  
            </header>
            <div class="group-value">
                <p class="value"><?php echo $vagas_ocupadas; ?></p>
                <p class="muted">vaga(s) ocupada(s) e </p>
                <p class="value"><?php echo $total_vagas - $vagas_ocupadas; ?></p>
                <p class="muted">vaga(s) disponível(eis)</p>
            </div>
        </div>
        <div class="dashboard-card">
            <header>
                <h2>Visitantes Hoje</h2>
                <div class="right">
                    <button class="btn btn-sm btn-outline" onclick="location.href='visitantes.php'">Gerenciar Visitantes</button>
                </div>  
            </header>
            <div class="group-value">
                <p class="value"><?php echo $visitantes_hoje; ?></p>
                <p class="muted">visitante(s) hoje</p>
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
                        <?php foreach($comunicados as $comunicado): ?>
                            <li class="list-item">
                                <div>
                                    <strong><?php echo htmlspecialchars($comunicado['titulo']); ?></strong>
                                    <p class="muted"><?php echo substr(htmlspecialchars($comunicado['mensagem']), 0, 100); ?>...</p>
                                    <small class="muted">
                                        Por <?php echo htmlspecialchars($comunicado['autor_nome'] ?? 'Desconhecido'); ?> - 
                                        <?php echo date('d/m/Y H:i', strtotime($comunicado['data_publicacao'])); ?>
                                    </small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <!-- Visitantes Ativos -->
        <section class="dashboard-section">
            <header>
                <h2>👥 Visitantes no Condomínio</h2>
                <button onclick="location.href='visitantes.php'" class="btn btn-sm btn-outline">Gerenciar</button>
            </header>
            <div class="section-content">
                <?php if(empty($visitantes_ativos)): ?>
                    <p class="muted">Nenhum visitante no condomínio no momento.</p>
                <?php else: ?>
                    <ul class="list-items">
                        <?php foreach($visitantes_ativos as $visitante): ?>
                            <li class="list-item">
                                <div>
                                    <strong><?php echo htmlspecialchars($visitante['nome']); ?></strong>
                                    <p class="muted">Visitando: Apto <?php echo htmlspecialchars($visitante['apartamento_visitado']); ?></p>
                                    <small class="muted">
                                        Entrada: <?php echo date('d/m/Y H:i', strtotime($visitante['data_entrada'])); ?>
                                    </small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <!-- Atividade Recente -->
        <section class="dashboard-section">
            <header>
                <h2>🕐 Atividade Recente</h2>
            </header>
            <div class="section-content">
                <h3>Últimos Moradores Cadastrados</h3>
                <?php if(empty($ultimos_moradores)): ?>
                    <p class="muted">Nenhum morador cadastrado ainda.</p>
                <?php else: ?>
                    <ul class="list-items">
                        <?php foreach($ultimos_moradores as $morador): ?>
                            <li class="list-item">
                                <span class="material-symbols-outlined">person</span>
                                <div>
                                    <strong><?php echo htmlspecialchars($morador['nome']); ?></strong>
                                    <small class="muted"><?php echo date('d/m/Y H:i', strtotime($morador['created_at'])); ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <h3 style="margin-top: 20px;">Últimos Veículos Cadastrados</h3>
                <?php if(empty($ultimos_veiculos)): ?>
                    <p class="muted">Nenhum veículo cadastrado ainda.</p>
                <?php else: ?>
                    <ul class="list-items">
                        <?php foreach($ultimos_veiculos as $veiculo): ?>
                            <li class="list-item">
                                <span class="material-symbols-outlined">directions_car</span>
                                <div>
                                    <strong><?php echo htmlspecialchars($veiculo['placa']); ?> - <?php echo htmlspecialchars($veiculo['modelo']); ?></strong>
                                    <p class="muted">Proprietário: <?php echo htmlspecialchars($veiculo['morador_nome'] ?? 'N/A'); ?></p>
                                    <small class="muted"><?php echo date('d/m/Y', strtotime($veiculo['created_at'])); ?></small>
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
 