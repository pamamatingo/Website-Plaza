// swiper-hover.js

// Obtener el contenedor del Swiper de ofertas
const offersSwiperContainer = document.querySelector('.offers-swiper');

// Verificar si existe el swiper antes de añadir eventos
if (offersSwiperContainer && offersSwiper) {
    offersSwiperContainer.addEventListener('mouseenter', () => {
        offersSwiper.autoplay.stop();
    });

    offersSwiperContainer.addEventListener('mouseleave', () => {
        offersSwiper.autoplay.start();
    });
}
