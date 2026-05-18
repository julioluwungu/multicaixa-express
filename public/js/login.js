const form = document.querySelector("form");

form.addEventListener("submit", (event) => {

    const email = document.querySelector("#email").value.trim();
    const senha = document.querySelector("#senha").value.trim();

    if (email === "" || senha === "") {
        event.preventDefault();

        alert("Preencha todos os campos");
    }

});