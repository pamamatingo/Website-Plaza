// scroll-top.js

// Botón de Scroll hacia arriba
const scrollToTopBtn = document.getElementById('scrollToTopBtn');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add('visible');
    } else {
        scrollToTopBtn.classList.remove('visible');
    }

    // Animación de Hero Section
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        const heroPosition = heroContent.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (heroPosition < screenPosition) {
            heroContent.classList.add('visible');
        }
    }
});

scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
