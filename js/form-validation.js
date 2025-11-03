// Validação de formulários
document.addEventListener("DOMContentLoaded", function () {
  // Adicionar validações aos formulários

  document.querySelectorAll("form.login-form").forEach(function (form) {
    form.addEventListener("submit", function (event) {
      if (!validateLoginForm(form)) {
        event.preventDefault();
      }
    });
  });
});

function validateLoginForm(form) {
  clearErrors(form);

  const cpf = form.querySelector('[name="cpf"]');
  const senha = form.querySelector('[name="senha"]');
  let ok = true;

  if (!validarCPF(cpf.value.trim()) || cpf.value.length > 11) {
    showError(cpf, "CPF inválido");
    ok = false;
  }

  if (!senha.value.trim() || senha.value.length < 8) {
    showError(senha, "Senha deve ter pelo menos 8 caracteres");
    ok = false;
  }

  return ok;
}

// VALIDAÇÃO DE FORMULÁRIOS ADICIONAIS PODEM SER ADICIONADAS AQUI

// VALIDAÇÃO DE OUTROS TIPOS DE DADOS PODEM SER ADICIONADAS AQUI

function showError(el, msg) {
  let next = el.nextElementSibling;
  if (!next || !next.classList.contains("error")) {
    next = document.createElement("div");
    next.className = "error";
    next.style.color = "#ef4444";
    next.style.fontSize = "13px";
    next.style.marginTop = "6px";
    el.parentNode.appendChild(next);
  }
  next.textContent = msg;
}

function clearErrors(form) {
  form.querySelectorAll(".error").forEach((e) => e.remove());
}

// não mecha aqui, por favor
function validarCPF(cpf) {
  cpf = cpf.replace(/[^\d]+/g, "");
  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
    return false;
  }

  let sum = 0;
  for (let i = 0; i < 9; i++) {
    sum += parseInt(cpf.charAt(i), 10) * (10 - i);
  }
  let rem = sum % 11;
  let digit1 = rem < 2 ? 0 : 11 - rem;
  if (parseInt(cpf.charAt(9), 10) !== digit1) {
    return false;
  }

  sum = 0;
  for (let i = 0; i < 10; i++) {
    sum += parseInt(cpf.charAt(i), 10) * (11 - i);
  }
  rem = sum % 11;
  let digit2 = rem < 2 ? 0 : 11 - rem;
  return parseInt(cpf.charAt(10), 10) === digit2;
}
