document.addEventListener('DOMContentLoaded', function() {
    const logoutLink = document.querySelector('a[href*="logout.php"]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            if (!confirm('¿Seguro que deseas cerrar sesión?')) {
                e.preventDefault();
            }
        });
    }

    const deleteLinks = document.querySelectorAll('a[href*="eliminar_oferta.php"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('¿Seguro que quieres eliminar esta oferta? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
});
