const senha = document.getElementById("senha");
const confirmar = document.getElementById("confirmar");
const forca = document.getElementById("forcaSenha");
const match = document.getElementById("matchSenha");

senha.addEventListener("input", function () {

    const value = senha.value;
    let strength = 0;

    if (value.length >= 6) strength++;
    if (value.match(/[A-Z]/)) strength++;
    if (value.match(/[0-9]/)) strength++;
    if (value.length >= 10) strength++;

    if (strength <= 1) {
        forca.textContent = "Senha fraca";
        forca.className = "strength weak";
    } else if (strength == 2 || strength == 3) {
        forca.textContent = "Senha média";
        forca.className = "strength medium";
    } else {
        forca.textContent = "Senha forte";
        forca.className = "strength strong";
    }
});

confirmar.addEventListener("input", function () {

    if (confirmar.value === senha.value) {
        match.textContent = "As senhas coincidem";
        match.style.color = "#22c55e";
    } else {
        match.textContent = "As senhas não coincidem";
        match.style.color = "#ef4444";
    }
});