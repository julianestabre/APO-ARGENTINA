document.addEventListener("DOMContentLoaded", () => {
    const menuIcon = document.querySelector(".menu-icon");
    const navbar = document.querySelector(".navbar");

    menuIcon.addEventListener("click", () => {
        if (navbar.classList.contains("active")) {
            navbar.style.maxHeight = "0";
            navbar.style.opacity = "0";
        } else {
            navbar.style.maxHeight = navbar.scrollHeight + "px";
            navbar.style.opacity = "1";
        }
        navbar.classList.toggle("active");
    });
});
