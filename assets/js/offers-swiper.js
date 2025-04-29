// assets/js/daily-offers.js

document.addEventListener('DOMContentLoaded', async () => {
    const section = document.getElementById('promociones');
    try {
      const res = await fetch('/service/api/ofertas.php');
      if (!res.ok) throw new Error('API error');
  
      const { ofertas } = await res.json();
  
      // Si no hay ofertas, ocultar carrusel
      if (!Array.isArray(ofertas) || ofertas.length === 0) {
        section.style.display = 'none';
        return;
      }
  
      // Cambiar título
      document.getElementById('offers-title').textContent = 'Ofertas del Día';
  
      // Renderizar slides
      const wrapper = document.getElementById('offers-swiper-wrapper');
      wrapper.innerHTML = '';
      ofertas.forEach(o => {
        const slide = document.createElement('div');
        slide.className = 'swiper-slide offer-card';
        slide.innerHTML = `
          <div class="badge">Oferta</div>
          <img src="${o.imagen_url}" alt="${o.descripcion}">
          <h3>${o.descripcion}</h3>
          <p class="price">
            <span class="original-price">$${parseFloat(o.precio_regular).toFixed(2)}</span>
            <span class="discount-price">$${parseFloat(o.precio_oferta).toFixed(2)}</span>
          </p>
        `;
        wrapper.appendChild(slide);
      });
  
      // Inicializar Swiper
      new Swiper('.offers-swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
          nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'
        },
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 }
        }
      });
  
    } catch (err) {
      console.error('Error cargando ofertas:', err);
      section.style.display = 'none';
    }
  });