-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS condominio;
USE condominio;

-- Tabela de usuários (moradores e admin)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    email VARCHAR(100),
    telefone VARCHAR(20),
    apartamento VARCHAR(20),
    bloco VARCHAR(10),
    senha VARCHAR(255) NOT NULL,
    role ENUM('admin', 'morador') DEFAULT 'morador',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de vagas
CREATE TABLE IF NOT EXISTS vagas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10) UNIQUE NOT NULL,
    tipo ENUM('coberta', 'descoberta') NOT NULL,
    status ENUM('disponivel', 'ocupada') DEFAULT 'disponivel',
    morador_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (morador_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabela de veículos
CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10) UNIQUE NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    cor VARCHAR(30),
    morador_id INT NOT NULL,
    vaga_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (morador_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (vaga_id) REFERENCES vagas(id) ON DELETE SET NULL
);

-- Tabela de visitantes
CREATE TABLE IF NOT EXISTS visitantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    apartamento_visitado VARCHAR(20) NOT NULL,
    data_entrada DATETIME NOT NULL,
    data_saida DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de comunicados
CREATE TABLE IF NOT EXISTS comunicados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    mensagem TEXT NOT NULL,
    autor_id INT NOT NULL,
    data_publicacao DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (autor_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Inserir usuário admin padrão
-- CPF: 00000000000 | Senha: admin123
INSERT INTO usuarios (nome, cpf, email, telefone, senha, role) 
VALUES ('Administrador', '00000000000', 'admin@condominio.com', '(00) 0000-0000', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Inserir um morador de exemplo
-- CPF: 11111111111 | Senha: morador123
INSERT INTO usuarios (nome, cpf, email, telefone, apartamento, bloco, senha, role) 
VALUES ('João Silva', '11111111111', 'joao@email.com', '(11) 98765-4321', '101', 'A', '$2y$10$Y4qXz8v3oB0wF.P0Gq3Zu.jZv8LxWEPxVHKqZvCYj4VUcL2qN7F5i', 'morador');

-- Inserir algumas vagas de exemplo
INSERT INTO vagas (numero, tipo, status) VALUES 
('001', 'coberta', 'disponivel'),
('002', 'coberta', 'disponivel'),
('003', 'descoberta', 'disponivel'),
('004', 'descoberta', 'disponivel'),
('005', 'coberta', 'disponivel');   

-- Inserir um comunicado de exemplo
INSERT INTO comunicados (titulo, mensagem, autor_id, data_publicacao)
VALUES ('Bem-vindo ao Sistema', 'Sistema de gestão condominial implementado com sucesso!', 1, NOW());
