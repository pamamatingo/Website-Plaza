// menu-hamburguesa.js

// Menú Hamburguesa: abrir y cerrar el menú
const hamburger = document.getElementById('hamburger');
const navbar = document.getElementById('navbar');

hamburger.addEventListener('click', () => {
    navbar.classList.toggle('hidden');
});
