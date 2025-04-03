// Mostrar botón cuando el usuario scrollea hacia abajo
window.onscroll = function() {
    let btnSubir = document.getElementById("btnSubir");
    if (document.documentElement.scrollTop > 300) {
        btnSubir.classList.add("show");
    } else {
        btnSubir.classList.remove("show");
    }
};

// Función para volver arriba suavemente
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}
