const form = document.querySelector("form");

if (form) {
    form.addEventListener("submit", function (e) {

        const email = document.querySelector("input[name='email_destino']").value.trim();
        const valor = document.querySelector("input[name='valor']").value;

        if (!email || !valor || valor <= 0) {
            e.preventDefault();
            alert("Preencha corretamente os campos da transferência.");
        }

    });
}