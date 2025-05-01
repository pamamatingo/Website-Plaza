<?php
// index.php
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="./assets/img/longoSinFondo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plaza Agropecuaria Mamá Tingó</title>

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/variables.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/hero.css">
    <link rel="stylesheet" href="./assets/css/offers.css">
    <link rel="stylesheet" href="./assets/css/productos.css">
    <link rel="stylesheet" href="./assets/css/services.css">
    <link rel="stylesheet" href="./assets/css/banks.css">
    <link rel="stylesheet" href="./assets/css/contact.css">
    <link rel="stylesheet" href="./assets/css/scroll-top.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">

    <!-- FontAwesome & Boxicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet">

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

    <!-- AOS & Swiper CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>

<body>

<!-- Header -->
<header class="header">
  <div class="logo-container">
      <img src="./assets/img/longoSinFondo.png" alt="Logo de Plaza Agropecuaria Mamá Tingó">
  </div>
  <button class="hamburger" id="hamburger"><i class="fas fa-bars"></i></button>
  <nav class="navbar hidden" id="navbar">
      <a href="nosotros.html">Nosotros</a>
      <a href="#promociones">Promociones</a>
      <a href="#productos">Productos</a>
      <a href="#servicios">Servicios</a>
      <a href="#contacto">Contacto</a>
  </nav>
</header>

<!-- Hero Section -->
<section>
  <img src="assets/img/fondoMamatingo.jpg" alt="Hero Image" class="hero-image">
  <div class="hero-content" data-aos="fade-up">
      <h2>¡Lleva más y paga menos!</h2>
      <p>Tu supermercado confiable en Santo Domingo Norte desde 2012.</p>
      <a href="#productos" class="cta-button">Ver Productos</a>
  </div>
</section>

<!-- Sección de Ofertas -->
<section id="promociones" class="offers">
    <h2 id="offers-title" class="offers-title" data-aos="fade-up">Ofertas Especiales</h2>
    <div class="swiper-container-wrapper">
      <div class="swiper-container offers-swiper" data-aos="fade-up">
        <div class="swiper-wrapper" id="offers-swiper-wrapper">
          <!-- Slides dinámicos inyectados por JS -->
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>

<!-- Productos -->
<section id="productos" class="productos">
    <h2 data-aos="fade-up">Productos Destacados</h2>
    <div class="filtros" data-aos="fade-up">
        <input type="text" id="search" placeholder="Buscar productos...">
        <select id="categoria">
            <option value="todos">Todas las Categorías</option>
            <option value="frutas">Frutas</option>
            <option value="verduras">Verduras</option>
            <option value="lacteos">Lácteos</option>
            <!-- Más categorías -->
        </select>
    </div>
    <div class="productos-lista" id="productos-lista" data-aos="fade-up">
        <!-- Productos dinámicos -->
    </div>
</section>

<!-- Servicios -->
<section id="servicios" class="services">
    <h2 data-aos="fade-up">Servicios que ofrecemos</h2>
    <div class="services-list">
        <div class="service-item" data-aos="zoom-in">
            <img src="./assets/img/pedir-prestado.png" alt="Sub Agentes Bancarios">
            <h3>Sub Agentes Bancarios</h3>
        </div>
        <div class="service-item" data-aos="zoom-in" data-aos-delay="100">
            <img src="./assets/img/facturas.svg" alt="Pago de Facturas Eléctricas">
            <h3>Pago de Facturas Eléctricas</h3>
        </div>
        <div class="service-item" data-aos="zoom-in" data-aos-delay="200">
            <img src="./assets/img/recargas.svg" alt="Recargas Telefónicas">
            <h3>Recargas Telefónicas</h3>
        </div>
    </div>
</section>

<!-- Subagentes Bancarios -->
<section class="banks">
    <h2 data-aos="fade-up">Sub Agentes Bancarios</h2>
    <div class="banks-list" data-aos="fade-up">
        <img src="./assets/img/popular-logo.png" alt="Banco Popular">
        <img src="./assets/img/bhd-logo.png" alt="Banco BHD León">
        <img src="./assets/img/banreservas-logo.png" alt="Banreservas">
    </div>
</section>


<!-- Contacto: sección optimizada -->
<section id="contacto" class="contacto">
  <h2>Contacto</h2>
  <div class="contacto__info">
    <p class="contacto__line">
      <svg class="icon"><use href="#icon-map-marker"/></svg>
      Ave. Hermanas Mirabal No. 60, Esq. Calle 4ta, Vista Bella.
    </p>
    <p class="contacto__line">
      <svg class="icon"><use href="#icon-phone"/></svg>
      <a href="tel:+18092455306">809-245-5306</a>,
      <a href="tel:+18493535454">849-353-5454</a>
    </p>
    <p class="contacto__line">
      <svg class="icon"><use href="#icon-envelope"/></svg>
      <a href="mailto:info@mamatingo.do">info@mamatingo.do</a>
    </p>
    <button class="btn btn--primary" onclick="scrollToMapa()">
      Ubícanos
    </button>
  </div>

  <!-- Placeholder LQIP; iframe se inyecta con JS -->
  <div id="mapa" class="contacto__mapa">
    <img
      src="img/mapa-placeholder.webp"
      alt="Mapa de ubicación"
      loading="lazy"
      class="contacto__mapa-img"
    >
  </div>
</section>


<!-- Incluir CSS y JS de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Botón de Scroll hacia arriba -->
<button class="scroll-to-top" id="scrollToTopBtn">
    <i class="fas fa-arrow-up"></i>
</button>




<!-- Footer -->
    <footer>
      <div class="footer-top">
        <div class="pt-exebar">

        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 footer-col-3">
              <div class="widget footer_widget">
                <h5 class="footer-title">Direccion</h5>
                <div class="gem-contacts">
                  <div class="gem-contacts-item gem-contacts-address">Ave. Hermanas Mirabal No. 60, Esq. Calle 4ta, Urbanización Vista Bella.<br>
                  </div>
                  <div class="gem-contacts-item gem-contacts-phone"><i class="fa fa-phone" aria-hidden="true"></i> Telefonos: <a href="https://api.whatsapp.com/send?phone=18493535454">849-353-5454</a></div>
                </div>
              </div>

            </div>
            <div class="col-12 col-lg-6 col-md-6 col-sm-12">
              <div class="row">
                <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                  <div class="widget footer_widget">
                    <h5 class="footer-title">Contactanos</h5>
                    <ul class="posts  styled">
                      <li class="clearfix gem-pp-posts">
                        <div class="gem-pp-posts-text">
                          <div class="gem-pp-posts-item">
                            <a href="">Email:
                            </a>
                          </div>
                          <div class="gem-pp-posts-date"><a href="mailto:info@mamatingo.do">info@mamatingo.do</a></div>
                        </div>
                      </li>
                      <li class="clearfix gem-pp-posts">
                        <div class="gem-pp-posts-text">
                          <div class="gem-pp-posts-item">
                            <a href="">Telefonos:
                            </a>
                          </div>
                          <div class="gem-pp-posts-date">809-245-5306, +1 849-353-5454</div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3 col-md-5 col-sm-12 footer-col-4">
              <div class="widget widget_gallery gallery-grid-4">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <div class="row">

            <div class="col-md-3">
              <div class="footer-site-info">&copy; 2025 Plaza Agropecuaria Mamá Tingó. Todos los derechos reservados.</a></div>
            </div>

            <div class="col-md-6">
              <nav id="footer-navigation" class="site-navigation footer-navigation centered-box" role="navigation">
                <ul id="footer-menu" class="nav-menu styled clearfix inline-inside">
                  <li id="menu-item-26" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-26"><a href="https://api.whatsapp.com/send?phone=18493535454">Asistencia</a></li>
                  <li id="menu-item-27" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-27"><a href="https://api.whatsapp.com/send?phone=18493535454">Contactanos</a></li>
                </ul>
              </nav>
            </div>

            <div class="col-md-3">
              <div id="footer-socials">
                <div class="socials inline-inside socials-colored">

                  <a href="https://www.facebook.com/profile.php?id=100069435377812" target="_blank" title="Facebook" class="socials-item">
                    <i class="bx bxl-facebook"></i>
                  </a>
                  <a href="https://www.instagram.com/plazamamatingo/?hl=es" target="_blank" title="Instagram" class="socials-item">
                    <i class="bx bxl-instagram"></i>
                  </a>
                  <a href="https://wa.me/8092455306" target="_blank" title="whatsapp" class="socials-item">
                    <i class="bx bxl-whatsapp"></i>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="https://daniellaharel.com/raindrops/js/raindrops.js"></script>


<!-- Scripts -->
<!-- Script de Api de Google maps-->
<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
      key: "AIzaSyBIxYbazIeu8gCGXx6pp-OA5Oioyscfnm8",
      v: "weekly",
    });
  </script>

<!-- Swiper JS para sliders -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- AOS JS para animaciones al hacer scroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<!-- GSAP para animaciones avanzadas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>


<!-- Script principal -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="./assets/js/aos-init.js"></script>
<script src="./assets/js/menu-hamburguesa.js"></script>
<script src="./assets/js/scroll-top.js"></script>
<script src="./assets/js/swiper-hover.js"></script>
<script src="./assets/js/header-search.js"></script>
<script src="./assets/js/vacancy-form.js"></script>
<script src="./assets/js/daily-offers.js"></script>
</body>
</html>
