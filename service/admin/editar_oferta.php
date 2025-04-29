<?php
// admin/editar_oferta.php

// --------------------------------------------------
// 1. Configuración de entorno y control de errores
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
// 2. Configuración de sesión segura y CSRF
// --------------------------------------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --------------------------------------------------
// 3. Autenticación y conexión a la base de datos
// --------------------------------------------------
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
if (!isLoggedIn()) {
    header('Location: /service/admin/login.php');
    exit;
}

// --------------------------------------------------
// 4. Obtener datos de la oferta
// --------------------------------------------------
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /service/admin/ofertas.php');
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM ofertas WHERE id = :id');
$stmt->execute([':id' => $id]);
$oferta = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$oferta) {
    header('Location: /service/admin/ofertas.php');
    exit;
}

// --------------------------------------------------
// 5. Procesar formulario de edición
// --------------------------------------------------
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Token CSRF inválido.';
    }

    // Recoger y validar datos
    $descripcion    = trim($_POST['descripcion'] ?? '');
    $precio_regular = filter_var($_POST['precio_regular'], FILTER_VALIDATE_FLOAT);
    $precio_oferta  = filter_var($_POST['precio_oferta'], FILTER_VALIDATE_FLOAT);
    $fecha_inicio   = $_POST['fecha_inicio'] ?? '';
    $fecha_fin      = $_POST['fecha_fin'] ?? '';

    if ($descripcion === '') {
        $errors[] = 'La descripción es obligatoria.';
    }
    if ($precio_regular === false) {
        $errors[] = 'Precio Regular inválido.';
    }
    if ($precio_oferta === false) {
        $errors[] = 'Precio de Oferta inválido.';
    }
    if ($precio_regular !== false && $precio_oferta !== false && $precio_regular <= $precio_oferta) {
        $errors[] = 'El Precio Regular debe ser mayor que el Precio de Oferta.';
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_inicio)) {
        $errors[] = 'Formato Fecha Inicio inválido.';
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_fin)) {
        $errors[] = 'Formato Fecha Fin inválido.';
    }

    // Si no hay errores, actualizar
    if (empty($errors)) {
        $update = $pdo->prepare(
            'UPDATE ofertas
             SET descripcion = :desc,
                 precio_regular = :pr,
                 precio_oferta = :po,
                 fecha_inicio = :fi,
                 fecha_fin = :ff
             WHERE id = :id'
        );
        $update->execute([
            ':desc' => $descripcion,
            ':pr'   => $precio_regular,
            ':po'   => $precio_oferta,
            ':fi'   => $fecha_inicio,
            ':ff'   => $fecha_fin,
            ':id'   => $id,
        ]);
        header('Location: /service/admin/ofertas.php?msg=actualizado');
        exit;
    }
}

// --------------------------------------------------
// 6. Preparar datos para la vista
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
    <title>Editar Oferta #<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
<a href="#main-content" class="visually-hidden-focusable">Saltar al contenido principal</a>
<main id="main-content" class="container mt-4">
    <h2>Editar Oferta #<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?></h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? $oferta['descripcion'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="precio_regular" class="form-label">Precio Regular</label>
                <input type="number" step="0.01" id="precio_regular" name="precio_regular" class="form-control" value="<?= htmlspecialchars($_POST['precio_regular'] ?? $oferta['precio_regular'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-6">
                <label for="precio_oferta" class="form-label">Precio de Oferta</label>
                <input type="number" step="0.01" id="precio_oferta" name="precio_oferta" class="form-control" value="<?= htmlspecialchars($_POST['precio_oferta'] ?? $oferta['precio_oferta'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($_POST['fecha_inicio'] ?? $oferta['fecha_inicio'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-6">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?= htmlspecialchars($_POST['fecha_fin'] ?? $oferta['fecha_fin'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
        <a href="/service/admin/ofertas.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
