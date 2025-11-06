# Sistema de Gestão Condominial

Sistema web completo para gerenciamento de condomínios, desenvolvido em PHP puro com MySQL.

## 📋 Funcionalidades

### Para Administradores
- **Dashboard Administrativo** - Visão geral com estatísticas do condomínio
- **Gerenciamento de Moradores** - Cadastro completo de moradores (nome, CPF, apartamento, bloco)
- **Controle de Vagas** - Gerenciamento de vagas cobertas e descobertas
- **Cadastro de Veículos** - Registro de veículos vinculados aos moradores
- **Registro de Visitantes** - Controle de entrada e saída de visitantes
- **Comunicados** - Publicação de avisos e comunicados aos moradores

### Para Moradores
- **Dashboard do Morador** - Acesso às informações pessoais
- **Visualização de Comunicados** - Consulta aos avisos do condomínio
- **Consulta de Perfil** - Visualização dos dados cadastrais

## 🗄️ Estrutura do Banco de Dados

O sistema utiliza 5 tabelas principais:

- **usuarios** - Armazena moradores e administradores
- **vagas** - Controle de vagas de estacionamento
- **veiculos** - Registro de veículos dos moradores
- **visitantes** - Log de entrada/saída de visitantes
- **comunicados** - Avisos e comunicados publicados

## 🚀 Instalação

### Pré-requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Apache (XAMPP, WAMP, ou similar)

### Passos de Instalação

1. Clone ou baixe o projeto para a pasta do servidor web:
```bash
# Para XAMPP
c:\xampp\htdocs\sis-condominio
```

2. Importe o banco de dados:
   - Abra o phpMyAdmin (http://localhost/phpmyadmin)
   - Crie um novo banco de dados chamado `condominio`
   - Importe o arquivo `database.sql`

3. Configure a conexão com o banco (se necessário):
   - Edite o arquivo `config/db.php`
   - Ajuste as credenciais de acesso ao MySQL

4. Acesse o sistema:
```
http://localhost/sis-condominio
```

## 🔐 Acesso ao Sistema

### Usuário Administrador
- **CPF:** 00000000000
- **Senha:** admin123

### Usuário Morador (exemplo)
- **CPF:** 11111111111
- **Senha:** morador123

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP (PDO para banco de dados)
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Segurança:** 
  - Senhas com hash bcrypt
  - Validação de sessões
  - Controle de acesso por perfil (admin/morador)
  - Proteção contra SQL Injection (prepared statements)

## 📁 Estrutura de Arquivos

```
sis-condominio/
├── config/
│   └── db.php              # Configuração do banco de dados
├── css/                    # Arquivos de estilo
├── includes/
│   ├── auth.php           # Sistema de autenticação
│   ├── header.php         # Cabeçalho padrão
│   └── footer.php         # Rodapé padrão
├── js/                     # Scripts JavaScript
├── pages/
│   ├── login.php          # Página de login
│   ├── dashboard-admin.php    # Dashboard administrativo
│   ├── dashboard-morador.php  # Dashboard do morador
│   ├── moradores.php      # Gestão de moradores
│   ├── vagas.php          # Gestão de vagas
│   ├── veiculos.php       # Gestão de veículos
│   ├── visitantes.php     # Registro de visitantes
│   ├── comunicados.php    # Sistema de comunicados
│   └── perfil.php         # Perfil do usuário
├── database.sql           # Script de criação do banco
└── index.php             # Página inicial (redirecionamento)
```

## 🔒 Segurança

- Sistema de autenticação baseado em sessões PHP
- Controle de acesso por perfil (RBAC)
- Senhas armazenadas com hash bcrypt (password_hash)
- Prepared statements para prevenir SQL Injection
- Validação de dados no servidor
- Sanitização de CPF e outros campos

## 📝 Observações

- O sistema foi desenvolvido em PHP puro, sem frameworks
- Utiliza PDO para comunicação segura com o banco de dados
- Interface responsiva e moderna
- Código limpo e bem estruturado
- Fácil manutenção e extensão

## 📄 Licença

Este projeto é de código aberto e está disponível para uso educacional e comercial.
