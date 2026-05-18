console.log("App carregado");

function formatarMoeda(valor) {
    return Number(valor).toFixed(2) + " Kz";
}

function mostrarAlerta(mensagem) {
    alert(mensagem);
}

function toggleMenu() {
    const menu = document.getElementById("menu");
    menu.classList.toggle("active");
}