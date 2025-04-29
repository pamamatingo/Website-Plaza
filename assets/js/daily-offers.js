// assets/js/daily-offers.js

document.addEventListener('DOMContentLoaded', async () => {
    const section = document.getElementById('promociones');
    try {
      const res = await fetch('/service/api/ofertas.php');
      if (!res.ok) throw new Error('Error en la API: ' + res.status);
  
      const { ofertas } = await res.json();
  
      // Ocultar sección si no hay ofertas
      if (!Array.isArray(ofertas) || ofertas.length === 0) {
        section.style.display = 'none';
        return;
      }
  
      // Actualizar título
      document.getElementById('offers-title').textContent = 'Ofertas del Día';
  
      // Mapa de unidades a abreviaturas
      const unitMap = {
        unidad: 'UND',
        libra:  'LB',
        kilogramo: 'KG',
        gramo:  'G',
        caja:   'Caja',
        paquete:'Pack',
        sixpack:'6pk',
        fardo:  'Fardo',
        litro: 'L',
        mililitro: 'ml'
      };
  
      // Renderizar slides
      const wrapper = document.getElementById('offers-swiper-wrapper');
      wrapper.innerHTML = '';
      ofertas.forEach(o => {
        // Obtenemos la unidad de medida (en tu BD campo unidad_medida)
        const rawUnit = o.unidad_medida ?? 'unidad';
        const unitLabel = unitMap[rawUnit] || rawUnit;
  
        const slide = document.createElement('div');
        slide.className = 'swiper-slide offer-card';
        slide.innerHTML = `
          <div class="badge">Oferta</div>
          <img src="${o.imagen_url}" alt="${o.descripcion}">
          <h3>${o.descripcion}</h3>
          <p class="price">
            <span class="original-price">
              $${parseFloat(o.precio_regular).toFixed(2)} ${unitLabel}
            </span>
            <span class="discount-price">
              $${parseFloat(o.precio_oferta).toFixed(2)} ${unitLabel}
            </span>
          </p>
        `;
        wrapper.appendChild(slide);
      });
  
      // Configurar Swiper: autoplay si >3 slides, centrar si solo 1
      const swiperOptions = {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: ofertas.length > 1,
        centeredSlides: ofertas.length === 1,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        breakpoints: {
          768:  { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        }
      };
      if (ofertas.length > 3) {
        swiperOptions.autoplay = { delay: 5000, disableOnInteraction: false };
      }
  
      new Swiper('.offers-swiper', swiperOptions);
  
    } catch (err) {
      console.error('Error cargando ofertas:', err);
      section.style.display = 'none';
    }
  });
  