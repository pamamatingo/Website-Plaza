// header-search.js

// Buscar productos desde el header
const headerSearchInput = document.getElementById('header-search-input');
const headerSearchButton = document.getElementById('header-search-button');

// Verificar que los elementos existan
if (headerSearchInput && headerSearchButton) {
    headerSearchButton.addEventListener('click', () => {
        const query = headerSearchInput.value.trim();
        if (query) {
            window.location.href = '#productos';
            const mainSearchInput = document.getElementById('search');
            const categoriaSelect = document.getElementById('categoria');

            if (mainSearchInput && categoriaSelect && typeof mostrarProductos === 'function') {
                mainSearchInput.value = query;
                mostrarProductos(categoriaSelect.value, query);
            }
        }
    });
}
