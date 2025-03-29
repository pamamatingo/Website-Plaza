// Inicializar AOS
AOS.init({
    duration: 1000,
    once: true,
});

// Menú hamburguesa
const hamburger = document.getElementById('hamburger');
const navbar = document.getElementById('navbar');

hamburger.addEventListener('click', () => {
    navbar.classList.toggle('hidden');
});

// Botón de scroll hacia arriba
const scrollToTopBtn = document.getElementById('scrollToTopBtn');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add('visible');
    } else {
        scrollToTopBtn.classList.remove('visible');
    }

    // Animación del Hero Section
    const heroContent = document.querySelector('.hero-content');
    const heroPosition = heroContent.getBoundingClientRect().top;
    const screenPosition = window.innerHeight / 1.3;

    if (heroPosition < screenPosition) {
        heroContent.classList.add('visible');
    }
});

scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Inicializar Swiper para Ofertas
const offersSwiper = new Swiper('.offers-swiper', {
    loop: true,
    autoplay: {
        delay: 1000,
        disableOnInteraction: false,
    },
    slidesPerView: 3,
    spaceBetween: 10,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 1,
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 2,
        },
        // when window width is >= 992px
        992: {
            slidesPerView: 3,
        },
    }
});

// Datos de ofertas por día
// Datos de ofertas por día
const dailyOffers = {
    0: { // Domingo
        department: 'panadería',
        message: '¡Domingo de ofertas en panadería fresca!',
        offers: [
            { id: 10, nombre: 'Pan Integral', precioOriginal: '$2.00', precioOferta: '$1.50', imagen: 'img/pan_integral.jpg' },
            { id: 11, nombre: 'Croissant', precioOriginal: '$1.50', precioOferta: '$1.00', imagen: 'img/croissant.jpg' },
            { id: 12, nombre: 'Baguette', precioOriginal: '$2.50', precioOferta: '$2.00', imagen: 'img/baguette.jpg' },
            { id: 13, nombre: 'Muffin de Arándanos', precioOriginal: '$1.80', precioOferta: '$1.30', imagen: 'img/muffin_arandanos.jpg' },
            { id: 14, nombre: 'Donut Glaseado', precioOriginal: '$1.20', precioOferta: '$0.90', imagen: 'img/donut_glaseado.jpg' }
        ]
    },
    1: { // Lunes
        department: 'lácteos',
        message: '¡Lunes de ofertas en lácteos deliciosos!',
        offers: [
            { id: 15, nombre: 'Leche Descremada', precioOriginal: '$1.20', precioOferta: '$1.00', imagen: 'img/leche_descremada.jpg' },
            { id: 16, nombre: 'Queso Cheddar', precioOriginal: '$3.00', precioOferta: '$2.50', imagen: 'img/queso_cheddar.jpg' },
            { id: 17, nombre: 'Yogur Griego', precioOriginal: '$1.50', precioOferta: '$1.20', imagen: 'img/yogur_griego.jpg' },
            { id: 18, nombre: 'Mantequilla', precioOriginal: '$2.00', precioOferta: '$1.70', imagen: 'img/mantequilla.jpg' },
            { id: 19, nombre: 'Crema para Café', precioOriginal: '$1.80', precioOferta: '$1.50', imagen: 'img/crema_cafe.jpg' }
        ]
    },
    2: { // Martes
        department: 'vegetales',
        message: '¡Martes de ofertas en vegetales frescos!',
        offers: [
            { id: 20, nombre: 'Tomate', precioOriginal: '$0.80', precioOferta: '$0.60', imagen: 'img/tomate.jpg' },
            { id: 21, nombre: 'Lechuga', precioOriginal: '$0.50', precioOferta: '$0.40', imagen: 'img/lechuga.jpg' },
            { id: 22, nombre: 'Zanahoria', precioOriginal: '$0.70', precioOferta: '$0.50', imagen: 'img/zanahoria.jpg' },
            { id: 23, nombre: 'Brócoli', precioOriginal: '$1.00', precioOferta: '$0.80', imagen: 'img/brocoli.jpg' },
            { id: 24, nombre: 'Pimiento Rojo', precioOriginal: '$0.90', precioOferta: '$0.70', imagen: 'img/pimiento_rojo.jpg' }
        ]
    },
    3: { // Miércoles
        department: 'carnes',
        message: '¡Miércoles de carnes a precios increíbles!',
        offers: [
            { id: 25, nombre: 'Carne de Res', precioOriginal: '$5.00', precioOferta: '$4.50', imagen: 'img/carne_res.jpg' },
            { id: 26, nombre: 'Pechuga de Pollo', precioOriginal: '$4.00', precioOferta: '$3.50', imagen: 'img/pechuga_pollo.jpg' },
            { id: 27, nombre: 'Chuleta de Cerdo', precioOriginal: '$4.50', precioOferta: '$4.00', imagen: 'img/chuleta_cerdo.jpg' },
            { id: 28, nombre: 'Pavo Molido', precioOriginal: '$3.80', precioOferta: '$3.30', imagen: 'img/pavo_molido.jpg' },
            { id: 29, nombre: 'Salchicha Italiana', precioOriginal: '$3.50', precioOferta: '$3.00', imagen: 'img/salchicha_italiana.jpg' }
        ]
    },
    4: { // Jueves
        department: 'embutidos',
        message: '¡Jueves de embutidos en promoción!',
        offers: [
            { id: 30, nombre: 'Jamón', precioOriginal: '$3.00', precioOferta: '$2.50', imagen: 'img/jamon.jpg' },
            { id: 31, nombre: 'Salami', precioOriginal: '$2.80', precioOferta: '$2.30', imagen: 'img/salami.jpg' },
            { id: 32, nombre: 'Chorizo', precioOriginal: '$3.20', precioOferta: '$2.70', imagen: 'img/chorizo.jpg' },
            { id: 33, nombre: 'Mortadela', precioOriginal: '$2.50', precioOferta: '$2.00', imagen: 'img/mortadela.jpg' },
            { id: 34, nombre: 'Pepperoni', precioOriginal: '$3.00', precioOferta: '$2.50', imagen: 'img/pepperoni.jpg' }
        ]
    },
    5: { // Viernes
        department: 'abarrotes',
        message: '¡Viernes de abarrotes con grandes descuentos!',
        offers: [
            { id: 35, nombre: 'Arroz', precioOriginal: '$1.00', precioOferta: '$0.80', imagen: 'img/arroz.jpg' },
            { id: 36, nombre: 'Frijoles Negros', precioOriginal: '$1.20', precioOferta: '$1.00', imagen: 'img/frijoles_negros.jpg' },
            { id: 37, nombre: 'Aceite de Oliva', precioOriginal: '$5.00', precioOferta: '$4.50', imagen: 'img/aceite_oliva.jpg' },
            { id: 38, nombre: 'Pasta Espagueti', precioOriginal: '$1.50', precioOferta: '$1.20', imagen: 'img/pasta_espagueti.jpg' },
            { id: 39, nombre: 'Azúcar Morena', precioOriginal: '$2.00', precioOferta: '$1.70', imagen: 'img/azucar_morena.jpg' }
        ]
    },
    6: { // Sábado
        department: 'frutas',
        message: '¡Sábado de ofertas en frutas jugosas!',
        offers: [
            { id: 40, nombre: 'Banana', precioOriginal: '$0.30', precioOferta: '$0.20', imagen: './assets/img/bananas.jpg' },
            { id: 41, nombre: 'Naranja', precioOriginal: '$0.60', precioOferta: '$0.50', imagen: 'img/naranja.jpg' },
            { id: 42, nombre: 'Uvas', precioOriginal: '$2.50', precioOferta: '$2.00', imagen: 'img/uvas.jpg' },
            { id: 43, nombre: 'Piña', precioOriginal: '$3.00', precioOferta: '$2.50', imagen: 'img/pina.jpg' },
            { id: 44, nombre: 'Sandía', precioOriginal: '$4.00', precioOferta: '$3.50', imagen: 'img/sandia.jpg' }
        ]
    }
};


// Función para mostrar las ofertas del día
function displayDailyOffers() {
    const today = new Date().getDay(); // Obtener el día actual (0-6)
    const todayOffers = dailyOffers[today];

    // Actualizar el mensaje
    const offersTitle = document.getElementById('offers-title');
    offersTitle.textContent = todayOffers.message;

    // Limpiar las ofertas existentes en el carrusel
    const offersWrapper = document.querySelector('.offers-swiper .swiper-wrapper');
    offersWrapper.innerHTML = '';

    // Agregar las ofertas al carrusel
    todayOffers.offers.forEach(offer => {
        const slide = document.createElement('div');
        slide.className = 'swiper-slide offer-card';
        slide.innerHTML = `
            <div class="badge">Oferta</div>
            <img src="${offer.imagen}" alt="${offer.nombre}">
            <h3>${offer.nombre}</h3>
            <p class="price">
                <span class="original-price">${offer.precioOriginal}</span>
                <span class="discount-price">${offer.precioOferta}</span>
            </p>
            
        `;
        offersWrapper.appendChild(slide);
    });

    // Re-inicializar Swiper (ya que cambiamos las diapositivas)
    offersSwiper.update();
}

// Productos
const productos = [
    { id: 1, nombre: 'Manzana', categoria: 'frutas', precio: '$1.00', imagen: 'img/manzana.jpg' },
    { id: 2, nombre: 'Lechuga', categoria: 'verduras', precio: '$0.80', imagen: 'img/lechuga.jpg' },
    { id: 3, nombre: 'Leche', categoria: 'lacteos', precio: '$1.50', imagen: 'img/leche.jpg' },
    // Añade más productos
];

const productosLista = document.getElementById('productos-lista');
const searchInput = document.getElementById('search');
const categoriaSelect = document.getElementById('categoria');

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

    // Re-inicializar AOS para nuevos elementos
    AOS.refresh();
}

searchInput.addEventListener('input', () => {
    mostrarProductos(categoriaSelect.value, searchInput.value);
});

categoriaSelect.addEventListener('change', () => {
    mostrarProductos(categoriaSelect.value, searchInput.value);
});

// Inicializar productos y ofertas del día
document.addEventListener('DOMContentLoaded', function() {
    displayDailyOffers();
    mostrarProductos();

    // Oferta diaria basada en el día actual
    const daysOffers = {
        2: '¡Martes de ofertas en vegetales frescos!',
        3: '¡Miércoles de carnes a precios increíbles!',
        4: '¡Jueves de embutidos en promoción!',
        5: '¡Viernes de abarrotes con grandes descuentos!'
    };
    const today = new Date().getDay();
    if (daysOffers[today]) {
        const offerBanner = document.createElement('div');
        offerBanner.className = 'daily-offer';
        offerBanner.textContent = daysOffers[today];
        document.body.insertBefore(offerBanner, document.body.firstChild);
    }
});
/*
// Agregar al carrito
let carrito = [];
const cartButton = document.getElementById('cart-button');
const cartCount = document.getElementById('cart-count');

// Evento para agregar productos al carrito (ofertas y productos)
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('agregar-carrito')) {
        const productoId = e.target.getAttribute('data-id');
        const producto = obtenerProductoPorId(productoId);
        if (producto) {
            agregarAlCarrito(producto);

            // Animación con GSAP
            gsap.fromTo(e.target, { scale: 1 }, { scale: 1.2, duration: 0.2, yoyo: true, repeat: 1 });
        }
    }
});

function obtenerProductoPorId(id) {
    // Buscar en productos
    let producto = productos.find(p => p.id == id);
    if (producto) return producto;

    // Buscar en las ofertas del día actual
    const today = new Date().getDay();
    const todayOffers = dailyOffers[today].offers;
    producto = todayOffers.find(o => o.id == id);
    if (producto) return producto;

    // Buscar en dailyOffers de otros días (opcional)
    for (let day in dailyOffers) {
        if (day == today) continue; // Ya lo revisamos
        let offers = dailyOffers[day].offers;
        producto = offers.find(o => o.id == id);
        if (producto) return producto;
    }

    return null;
}

function agregarAlCarrito(producto) {
    carrito.push(producto);
    actualizarCarrito();
}

function actualizarCarrito() {
    cartCount.textContent = carrito.length;
    console.log('Carrito:', carrito);
}
*/
// Validación del formulario de vacantes
const form = document.getElementById('vacancy-form');

form.addEventListener('submit', (e) => {
    const position = document.getElementById('position').value;
    const cv = document.getElementById('cv').files[0];

    if (!position || !cv) {
        e.preventDefault();
        alert('Por favor, completa todos los campos y adjunta tu CV.');
    }
});

// Buscar productos desde el header
const headerSearchInput = document.getElementById('header-search-input');
const headerSearchButton = document.getElementById('header-search-button');

headerSearchButton.addEventListener('click', () => {
    const query = headerSearchInput.value;
    window.location.href = '#productos';
    searchInput.value = query;
    mostrarProductos(categoriaSelect.value, query);
});

// Pausar autoplay de Swiper al interactuar
const offersSwiperContainer = document.querySelector('.offers-swiper');

offersSwiperContainer.addEventListener('mouseenter', () => {
    offersSwiper.autoplay.stop();
});

offersSwiperContainer.addEventListener('mouseleave', () => {
    offersSwiper.autoplay.start();
});

