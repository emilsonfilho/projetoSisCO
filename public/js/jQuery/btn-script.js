let btnB, btnN;
function historicoB() {
    window.history.back();
}
function inicia() {
    btnB = document.getElementById("btnBack");

    btnB.addEventListener("click", historicoB);
}
window.addEventListener("load", inicia);
