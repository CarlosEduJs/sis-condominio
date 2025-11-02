# 🏢 Sistema de Gestão Condominial

Sistema web para gerenciamento de condomínios desenvolvido em PHP procedural, HTML, CSS e JavaScript.

## 👥 Equipe

- **Líder**: Carlos Eduardo Teixeira - Responsável por backend, banco de dados e configurações
- **Desenvolvedor 2**: [Carlos Eduardo] - Páginas X, Y, Z
- **Desenvolvedor 3**: [Jhonatan] - Páginas A, B, C
- **Desenvolvedor 4**: [Denilson] - Páginas D, E, F
- **Desenvolvedor 5**: [Daniel] - Páginas G, H, I

## 📋 Divisão de Trabalho

### ✅ Já Implementado (NÃO MEXER)
- ✅ Estrutura do banco de dados (`database.sql`)
- ✅ Configurações (`config/db.php`)
- ✅ Autenticação (`includes/auth.php`)
- ✅ Backend PHP de todas as páginas
- ✅ Estrutura base CSS (`css/style.css`)

### 🎨 Para Implementar (HTML/CSS)

#### Desenvolvedor 2
- [ ] `pages/dashboard-admin.php` - Cards de estatísticas e botões de ação
- [ ] `pages/moradores.php` - Formulário e tabela de moradores

#### Desenvolvedor 3
- [ ] `pages/vagas.php` - Formulário e tabela de vagas
- [ ] `pages/veiculos.php` - Formulário e tabela de veículos

#### Desenvolvedor 4
- [ ] `pages/visitantes.php` - Formulário de registro e listagem
- [ ] `pages/comunicados.php` - Formulário (admin) e listagem de comunicados

#### Desenvolvedor 5
- [ ] `pages/dashboard-morador.php` - Dashboard do morador
- [ ] `pages/perfil.php` - Formulário de edição de perfil
- [ ] `includes/header.php` - Header com navegação estilizada

## 🚀 Como Começar

### 1. Clone o Repositório
```bash
git clone [URL_DO_REPOSITORIO]
cd sis-condominio
```

### 2. Configure o Ambiente Local
- Instale o XAMPP (Apache + MySQL/MariaDB)
- Coloque o projeto em `C:\xampp\htdocs\sis-condominio`
- Inicie Apache e MySQL no XAMPP Control Panel

### 3. Configure o Banco de Dados
```bash
# Acesse phpMyAdmin: http://localhost/phpmyadmin
# Execute o arquivo database.sql
```

### 4. Acesse o Sistema
```
http://localhost/sis-condominio
```

**Login Admin:**
- CPF: `00000000000`
- Senha: `admin123`

**Login Morador:**
- CPF: `11111111111`
- Senha: `morador123`

## 📝 Fluxo de Trabalho Git

### Para Cada Desenvolvedor

#### 1. Crie sua branch
```bash
git checkout -b feature/seu-nome-paginas
# Exemplo: git checkout -b feature/joao-dashboard-admin
```

#### 2. Trabalhe nas suas páginas
- Edite APENAS os arquivos HTML das páginas atribuídas a você
- NÃO modifique arquivos de backend PHP (lógica no topo dos arquivos)
- Pode adicionar CSS em `css/` se necessário

#### 3. Commit frequente
```bash
git add .
git commit -m "feat: implementa HTML do dashboard admin"
```

#### 4. Envie para o GitHub
```bash
git push origin feature/seu-nome-paginas
```

#### 5. Abra um Pull Request
- Vá no GitHub
- Clique em "Compare & Pull Request"
- Descreva o que foi implementado
- Aguarde revisão do líder

### ⚠️ Regras Importantes

1. **NUNCA commite direto na branch `main`**
2. **SEMPRE trabalhe na sua própria branch**
3. **NUNCA modifique arquivos que não são seus**
4. **Antes de começar, sempre puxe as atualizações:**
   ```bash
   git checkout main
   git pull origin main
   git checkout -b sua-nova-branch
   ```

## 🎨 Estrutura de Arquivos

```
sis-condominio/
├── config/
│   └── db.php              ❌ NÃO MEXER
├── css/
│   ├── style.css           ✅ Pode adicionar estilos
│   ├── dashboard.css       ✅ Pode adicionar estilos
│   └── forms.css           ✅ Pode adicionar estilos
├── includes/
│   ├── auth.php            ❌ NÃO MEXER
│   ├── header.php          ✅ HTML/CSS apenas
│   └── footer.php          ✅ HTML/CSS apenas
├── js/
│   └── *.js                ✅ Pode adicionar JS
├── pages/
│   ├── *.php               ✅ HTML apenas (não mexer no PHP do topo)
└── database.sql            ❌ NÃO MEXER
```

## 🔧 Variáveis PHP Disponíveis

### Em todas as páginas (já no backend):
- `$_SESSION['user_id']` - ID do usuário logado
- `$_SESSION['role']` - 'admin' ou 'morador'
- `$_SESSION['nome']` - Nome do usuário
- `$error` - Mensagem de erro (se houver)
- `$success` - Mensagem de sucesso (se houver)

### Exemplos de uso no HTML:

```php
<!-- Exibir nome do usuário -->
<p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>

<!-- Mostrar mensagem de erro -->
<?php if ($error): ?>
    <div class="message-area error">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<!-- Loop em dados (exemplo: moradores) -->
<?php foreach ($moradores as $morador): ?>
    <tr>
        <td><?php echo htmlspecialchars($morador['nome']); ?></td>
        <td><?php echo htmlspecialchars($morador['cpf']); ?></td>
    </tr>
<?php endforeach; ?>
```

## 🎨 Classes CSS Disponíveis

```css
/* Botões */
.btn                 /* Botão base */
.btn-primary         /* Botão primário azul */
.btn-logout          /* Botão de logout */

/* Mensagens */
.message-area        /* Container de mensagem */
.message-area.error  /* Mensagem de erro */
.message-area.success /* Mensagem de sucesso */

/* Layout */
.container           /* Container centralizado */
.main-content        /* Conteúdo principal */
.main-header         /* Header */
.main-footer         /* Footer */
.main-nav            /* Navegação */

/* Forms */
.form-group          /* Grupo de input */
```

## ✅ Checklist Antes de Fazer PR

- [ ] Código está funcionando localmente
- [ ] Não quebrou nenhuma funcionalidade existente
- [ ] HTML está bem indentado e limpo
- [ ] CSS está em arquivos separados (não inline)
- [ ] Variáveis PHP usam `htmlspecialchars()` para segurança
- [ ] Commit messages são descritivas

## 🐛 Resolução de Conflitos

Se aparecer conflito ao fazer merge:

```bash
# 1. Atualize sua branch com a main
git checkout main
git pull origin main
git checkout sua-branch
git merge main

# 2. Resolva os conflitos manualmente nos arquivos
# 3. Adicione os arquivos resolvidos
git add .
git commit -m "resolve: conflitos com main"
git push origin sua-branch
```

## 📚 Recursos Úteis

- [Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
- [PHP Manual](https://www.php.net/manual/pt_BR/)
- [MDN Web Docs](https://developer.mozilla.org/)

---

💡 **Dica:** Sempre teste suas alterações localmente antes de fazer commit!
