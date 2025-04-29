<?php
// includes/navbar.php
// Asegúrate de definir $username y $csrf_token antes de requerir este archivo.

$navItems = [
  ['label'=>'Dashboard',    'url'=>'/service/admin/dashboard.php'],
  ['label'=>'Ver Ofertas',  'url'=>'/service/admin/ofertas.php'],
  ['label'=>'Crear Oferta', 'url'=>'/service/admin/nueva_oferta.php'],
];
$current = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="/service/admin/dashboard.php">Plaza Mamá Tingó</a>
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNav"
            aria-controls="mainNav"
            aria-expanded="false"
            aria-label="Alternar navegación">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto">
        <?php foreach ($navItems as $item):
          $active = ($current === basename($item['url'])) ? 'active' : '';
        ?>
          <li class="nav-item">
            <a class="nav-link <?= $active ?>" href="<?= $item['url'] ?>">
              <?= $item['label'] ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link disabled">Bienvenido, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></span>
        </li>
        <li class="nav-item">
          <form method="POST" action="/service/admin/logout.php" class="d-inline">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
