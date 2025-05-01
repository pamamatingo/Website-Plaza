function scrollToMapa() {
    const cont = document.getElementById('mapa');
    if (!cont.querySelector('iframe')) {
      const iframe = document.createElement('iframe');
      iframe.src = 'https://www.google.com/maps/embed?...';
      iframe.allowFullscreen = '';
      iframe.loading = 'lazy';
      cont.appendChild(iframe);
    }
    cont.scrollIntoView({ behavior: 'smooth' });
  }
  