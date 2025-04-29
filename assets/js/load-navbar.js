document.addEventListener('DOMContentLoaded', () => {
    const navbarContainer = document.getElementById('navbar-container');
    fetch('navbar.html') // Cambiar ruta si es necesario
        .then(response => response.text())
        .then(html => {
            navbarContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Error cargando el navbar:', error);
        });
});
