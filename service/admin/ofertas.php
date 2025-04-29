<?php
// admin/ofertas.php

// --------------------------------------------------
// 1. CONTROL DE ERRORES POR ENTORNO
// --------------------------------------------------
$env = getenv('APP_ENV') ?: 'production';
if ($env === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// --------------------------------------------------
// 2. CONFIG. DE SESIÓN
// --------------------------------------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);
session_start();

// --------------------------------------------------
// 3. CSRF TOKEN
// --------------------------------------------------
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --------------------------------------------------
// 4. AUTH & DB
// --------------------------------------------------
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
if (!isLoggedIn()) {
    header('Location: /service/admin/login.php');
    exit;
}

// --------------------------------------------------
// 5. FLASH MESSAGE
// --------------------------------------------------
$flash = '';
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'creado':       $flash = '¡Oferta creada exitosamente!'; break;
        case 'actualizado':  $flash = 'Oferta actualizada correctamente.'; break;
        case 'eliminado':    $flash = 'Oferta eliminada.'; break;
        case 'toggle':       $flash = 'Estado de oferta cambiado.'; break;
    }
}

// --------------------------------------------------
// 6. CONSULTA OFERTAS
// --------------------------------------------------
$stmt = $pdo->query(
    "SELECT id, descripcion, precio_regular, precio_oferta, fecha_inicio, fecha_fin, activo, creado_en
     FROM ofertas ORDER BY fecha_inicio DESC"
);
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --------------------------------------------------
// 7. VISTA
// --------------------------------------------------
$username   = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
$csrf_token = $_SESSION['csrf_token'];
require_once __DIR__ . '/../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listado de Ofertas – Panel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/service/assets/css/admin.css">
</head>
<body>
<a href="#main-content" class="visually-hidden-focusable">Saltar al contenido</a>
<main id="main-content" class="container mt-4">
  <?php if ($flash): ?>
    <div class="alert alert-success"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4">Ofertas registradas</h2>
    <a href="/service/admin/nueva_oferta.php" class="btn btn-success">+ Nueva Oferta</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Descripción</th>
          <th>Precio Reg.</th>
          <th>Precio Of.</th>
          <th>Inicio</th>
          <th>Fin</th>
          <th>Activo</th>
          <th>Creado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($ofertas)): ?>
          <tr><td colspan="9" class="text-center py-4">No hay ofertas.</td></tr>
        <?php else: ?>
          <?php foreach ($ofertas as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= number_format($row['precio_regular'],2) ?></td>
              <td><?= number_format($row['precio_oferta'],2) ?></td>
              <td><?= $row['fecha_inicio'] ?></td>
              <td><?= $row['fecha_fin'] ?></td>
              <td>
                <?= $row['activo']
                    ? '<span class="badge bg-success">Sí</span>'
                    : '<span class="badge bg-secondary">No</span>' ?>
              </td>
              <td><?= $row['creado_en'] ?></td>
              <td class="text-nowrap">
                <!-- Editar -->
                <a href="/service/admin/editar_oferta.php?id=<?= $row['id'] ?>" 
                   class="btn btn-sm btn-primary me-1">Editar</a>
                <!-- Toggle active -->
                <form method="POST" action="/service/admin/toggle_oferta.php" class="d-inline">
                  <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <button type="submit" 
                          class="btn btn-sm btn-warning me-1">
                    <?= $row['activo'] ? 'Desactivar' : 'Activar' ?>
                  </button>
                </form>
                <!-- Eliminar -->
                <form method="POST" action="/service/admin/eliminar_oferta.php" class="d-inline" 
                      onsubmit="return confirm('¿Eliminar oferta #<?= $row['id'] ?>?');">
                  <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
