# 🤝 Guia de Contribuição

## 📋 Antes de Começar

1. Certifique-se de que está na lista de desenvolvedores do projeto
2. Verifique qual(is) página(s) foi(ram) atribuída(s) a você
3. Configure seu ambiente local (XAMPP + banco de dados)

## 🔄 Fluxo de Trabalho

### 1️⃣ Crie sua Branch
```bash
# Sempre comece da branch main atualizada
git checkout main
git pull origin main

# Crie sua branch com nome descritivo
git checkout -b feature/[seu-nome]-[pagina]
```

**Exemplos de nomes de branch:**
- `feature/joao-dashboard-admin`
- `feature/maria-moradores`
- `feature/pedro-vagas`

### 2️⃣ Desenvolva

#### ✅ O que PODE fazer:
- Adicionar HTML dentro dos comentários `<!-- -->` nas páginas
- Adicionar CSS em arquivos `.css`
- Adicionar JavaScript em arquivos `.js`
- Usar as variáveis PHP já disponibilizadas pelo backend

#### ❌ O que NÃO PODE fazer:
- Modificar código PHP no topo dos arquivos (antes do `include header.php`)
- Alterar `config/db.php`
- Alterar `includes/auth.php`
- Alterar `database.sql`
- Modificar páginas de outros desenvolvedores

### 3️⃣ Teste Localmente

Antes de commitar, teste:
- A página carrega sem erros
- Formulários funcionam
- CSS está aplicado corretamente
- Não quebrou outras páginas

### 4️⃣ Commit

```bash
# Adicione seus arquivos
git add .

# Faça commit com mensagem descritiva
git commit -m "feat: implementa HTML do dashboard admin com cards de estatísticas"
```

**Padrão de mensagens de commit:**
- `feat: ` - Nova funcionalidade
- `fix: ` - Correção de bug
- `style: ` - Mudanças de estilo/formatação
- `refactor: ` - Refatoração de código
- `docs: ` - Mudanças na documentação

### 5️⃣ Push

```bash
git push origin feature/[seu-nome]-[pagina]
```

### 6️⃣ Pull Request

1. Acesse o repositório no GitHub
2. Clique em **"Compare & Pull Request"**
3. Preencha:
   - **Título:** Descrição curta (ex: "Implementa dashboard admin")
   - **Descrição:** O que foi feito, quais páginas foram alteradas
   - **Screenshots:** Se possível, adicione imagens da interface
4. Marque o líder como **Reviewer**
5. Aguarde aprovação

## 📝 Padrão de Código

### HTML
```php
<!-- BOM ✅ -->
<div class="dashboard-cards">
    <?php foreach ($moradores as $morador): ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($morador['nome']); ?></h3>
        </div>
    <?php endforeach; ?>
</div>

<!-- RUIM ❌ -->
<div class="dashboard-cards">
<?php foreach ($moradores as $morador): ?>
<div class="card">
<h3><?php echo $morador['nome']; ?></h3>
</div>
<?php endforeach; ?>
</div>
```

### CSS
```css
/* BOM ✅ - Usar variáveis CSS */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px;
}

/* RUIM ❌ - Valores hardcoded */
.card {
    background: #f0f2f5;
    border: 1px solid #d3d9de;
    border-radius: 15px;
    padding: 20px;
}
```

### Segurança
```php
<!-- SEMPRE use htmlspecialchars() -->
<?php echo htmlspecialchars($user['nome']); ?>

<!-- NUNCA imprima direto -->
<?php echo $user['nome']; ?> ❌
```

## ✅ Checklist de PR

Antes de abrir o Pull Request, confirme:

- [ ] Código testado localmente
- [ ] Nenhum erro no console do navegador
- [ ] Nenhum erro PHP (verificar logs)
- [ ] HTML bem indentado
- [ ] CSS organizado (sem estilos inline)
- [ ] Variáveis PHP com `htmlspecialchars()`
- [ ] Commit messages descritivas
- [ ] Branch atualizada com a main

---

💡 **Lembre-se:** Código limpo é código que outros conseguem entender e manter!
