// Main JavaScript
// Funções gerais do sistema

document.addEventListener("DOMContentLoaded", function () {
  // Inicialização geral
  console.log("Sistema iniciado");

  const navLinks = document.querySelectorAll("nav a");

  navLinks.forEach((link) => {
    if (isActivePage(link.getAttribute("href"))) {
      link.classList.add("active");
    }
  });
});

function isActivePage(page) {
  return window.location.pathname.endsWith(page);
}

function toggleMenu() {
  const menuContent = document.querySelector(".menu-content");
  const portalMenu = document.querySelector(".portal-menu");
  menuContent.classList.toggle("active");
  portalMenu.classList.toggle("active");

  portalMenu.addEventListener("click", function () {
    menuContent.classList.remove("active");
    portalMenu.classList.remove("active");
  });
}

// Funções auxiliares serão implementadas conforme necessário
