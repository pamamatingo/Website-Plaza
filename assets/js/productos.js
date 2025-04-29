// productos.js

// Productos destacados
const productos = [
    { id: 1, nombre: 'Manzana', categoria: 'frutas', precio: '$1.00', imagen: 'img/manzana.jpg' },
    { id: 2, nombre: 'Lechuga', categoria: 'verduras', precio: '$0.80', imagen: 'img/lechuga.jpg' },
    { id: 3, nombre: 'Leche', categoria: 'lacteos', precio: '$1.50', imagen: 'img/leche.jpg' },
    // Puedes agregar más productos aquí
];

// Referencias al DOM
const productosLista = document.getElementById('productos-lista');
const searchInput = document.getElementById('search');
const categoriaSelect = document.getElementById('categoria');

// Función para mostrar productos filtrados
function mostrarProductos(filtro = 'todos', busqueda = '') {
    productosLista.innerHTML = '';

    const filtrados = productos.filter(producto => {
        const coincideCategoria = filtro === 'todos' || producto.categoria === filtro;
        const coincideBusqueda = producto.nombre.toLowerCase().includes(busqueda.toLowerCase());
        return coincideCategoria && coincideBusqueda;
    });

    filtrados.forEach(producto => {
        const card = document.createElement('div');
        card.className = 'producto-card';
        card.setAttribute('data-aos', 'fade-up');
        card.innerHTML = `
            <img src="${producto.imagen}" alt="${producto.nombre}">
            <h3>${producto.nombre}</h3>
            <p>${producto.precio}</p>
        `;
        productosLista.appendChild(card);
    });

    // Refrescar animaciones AOS
    AOS.refresh();
}

// Eventos de búsqueda y filtro
searchInput.addEventListener('input', () => {
    mostrarProductos(categoriaSelect.value, searchInput.value);
});

categoriaSelect.addEventListener('change', () => {
    mostrarProductos(categoriaSelect.value, searchInput.value);
});

// Ejecutar al cargar
document.addEventListener('DOMContentLoaded', mostrarProductos);
