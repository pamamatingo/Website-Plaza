<?php
// Debug: muestra todos los errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// El resto de tu código…

// admin/nueva_oferta.php

// 1. Entorno y control de errores
// --------------------------------------------------
$env = getenv('APP_ENV') ?: 'production';
if ($env === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// 2. Sesión segura + CSRF
// --------------------------------------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 3. Autenticación y conexión BD
// --------------------------------------------------
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
if (!isLoggedIn()) {
    header('Location: /service/admin/login.php');
    exit;
}

// 4. Opciones para select
// --------------------------------------------------
$units = [
    'unidad','libra','kilogramo','gramo','caja','paquete','sixpack','fardo','litro','mililitro'
];
$departments = [
    'Frutas y Verduras','Carnes','Lácteos','Panadería','Bebidas',
    'Limpieza','Hogar','Abarrotes','Congelados','Otros'
];

// 5. Preparar validación y almacenamiento
// --------------------------------------------------
$errors = [];
$values = [
    'descripcion'     => '',
    'precio_regular'  => '',
    'precio_oferta'   => '',
    'fecha_inicio'    => '',
    'fecha_fin'       => '',
    'imagen_url'      => '',
    'unidadMedida'    => '',
    'departamento'    => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // a) CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Token de seguridad inválido.';
    }

    // b) Carga masiva
    if (!empty($_FILES['bulk_file']['tmp_name']) && $_FILES['bulk_file']['error'] === UPLOAD_ERR_OK) {
        $lines = file($_FILES['bulk_file']['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $insertCount = 0;
        foreach ($lines as $idx => $line) {
            $cols = array_map('trim', explode(',', $line));
            if (count($cols) < 8) {
                $errors[] = "Línea " . ($idx+1) . " malformada.";
                continue;
            }
            list($desc, $pr, $po, $fi, $ff, $img, $um, $dep) = $cols;
            // validaciones
            if (!is_numeric($pr) || !is_numeric($po) || $pr <= $po) {
                $errors[] = "Línea " . ($idx+1) . ": precio_regular debe ser > precio_oferta.";
                continue;
            }
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fi) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $ff)) {
                $errors[] = "Línea " . ($idx+1) . ": formato de fecha inválido.";
                continue;
            }
            $desc = ucwords(strtolower($desc));
            $stmt = $pdo->prepare(
                "INSERT INTO ofertas
                 (descripcion, precio_regular, precio_oferta, imagen_url, fecha_inicio, fecha_fin, unidad_medida, departamento, activo, creado_en)
                 VALUES (:desc, :pr, :po, :img, :fi, :ff, :um, :dep, 1, NOW())"
            );
            $stmt->execute([
                ':desc'=> $desc,
                ':pr'  => $pr,
                ':po'  => $po,
                ':img' => $img,
                ':fi'  => $fi,
                ':ff'  => $ff,
                ':um'  => in_array($um, $units)?$um:'unidad',
                ':dep' => in_array($dep, $departments)?$dep:'Otros',
            ]);
            $insertCount++;
        }
        if ($insertCount) {
            header("Location: /service/admin/ofertas.php?msg=bulk_creadas&count={$insertCount}");
            exit;
        }
    } else {
        // c) Validación individual
        foreach ($values as $key => &$val) {
            $val = trim($_POST[$key] ?? '');
            if ($val === '') {
                $errors[$key] = 'Este campo es obligatorio.';
            }
        }
        unset($val);
        if (!isset($errors['precio_regular']) && !filter_var($values['precio_regular'], FILTER_VALIDATE_FLOAT)) {
            $errors['precio_regular'] = 'Número inválido.';
        }
        if (!isset($errors['precio_oferta']) && !filter_var($values['precio_oferta'], FILTER_VALIDATE_FLOAT)) {
            $errors['precio_oferta'] = 'Número inválido.';
        }
        if (empty($errors) && $values['precio_regular'] <= $values['precio_oferta']) {
            $errors['precio_regular'] = 'El Precio Regular debe ser mayor que Oferta.';
        }
        foreach (['fecha_inicio','fecha_fin'] as $df) {
            if (!isset($errors[$df]) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $values[$df])) {
                $errors[$df] = 'Formato de fecha inválido.';
            }
        }
        if ($values['imagen_url'] !== '' && !filter_var($values['imagen_url'], FILTER_VALIDATE_URL)) {
            $errors['imagen_url'] = 'URL inválida.';
        }
        if (!isset($errors['unidadMedida']) && !in_array($values['unidadMedida'], $units)) {
            $errors['unidadMedida'] = 'Selecciona unidad válida.';
        }
        if (!isset($errors['departamento']) && !in_array($values['departamento'], $departments)) {
            $errors['departamento'] = 'Selecciona departamento válido.';
        }
        if (empty($errors)) {
            $desc = ucwords(strtolower($values['descripcion']));
            $stmt = $pdo->prepare(
                "INSERT INTO ofertas
                 (descripcion, precio_regular, precio_oferta, imagen_url, fecha_inicio, fecha_fin, unidad_medida, departamento, activo, creado_en)
                 VALUES (:desc, :pr, :po, :img, :fi, :ff, :um, :dep, 1, NOW())"
            );
            $stmt->execute([
                ':desc'=> $desc,
                ':pr'  => $values['precio_regular'],
                ':po'  => $values['precio_oferta'],
                ':img' => $values['imagen_url'],
                ':fi'  => $values['fecha_inicio'],
                ':ff'  => $values['fecha_fin'],
                ':um'  => $values['unidadMedida'],
                ':dep' => $values['departamento'],
            ]);
            header('Location: /service/admin/ofertas.php?msg=creado');
            exit;
        }
    }
}

// 6. Datos para la vista
// --------------------------------------------------
$username   = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
$csrf_token = $_SESSION['csrf_token'];

// 7. Incluir barra de navegación
// --------------------------------------------------
require_once __DIR__ . '/../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear Oferta – Panel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
  <a href="#main-content" class="visually-hidden-focusable">Saltar al contenido principal</a>
  <main id="main-content" class="container mb-5">
    <div class="form-container mx-auto" style="max-width:700px;">
      <h2 class="form-title mb-4">Crear Nueva Oferta</h2>

      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ((array)$errors as $e): ?>
              <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

        <!-- Carga masiva -->
        <div class="mb-4">
          <label for="bulk_file" class="form-label">Carga masiva (.txt)</label>
          <input type="file" class="form-control" id="bulk_file" name="bulk_file" accept=".txt">
          <small class="text-muted">Línea: descripción,precio_regular,precio_oferta,fecha_inicio,fecha_fin,imagen_url,unidadMedida,departamento</small>
        </div>

        <!-- Formulario manual -->
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripci&oacute;n</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="2"><?= htmlspecialchars($values['descripcion']) ?></textarea>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="precio_regular" class="form-label">Precio Regular</label>
            <input type="number" step="0.01" class="form-control" id="precio_regular" name="precio_regular" value="<?= htmlspecialchars($values['precio_regular']) ?>">
          </div>
          <div class="col-md-6">
            <label for="precio_oferta" class="form-label">Precio de Oferta</label>
            <input type="number" step="0.01" class="form-control" id="precio_oferta" name="precio_oferta" value="<?= htmlspecialchars($values['precio_oferta']) ?>">
          </div>
        </div>
        <div class="row g-3 mt-3">
          <div class="col-md-6">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($values['fecha_inicio']) ?>">
          </div>
          <div class="col-md-6">
            <label for="fecha_fin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($values['fecha_fin']) ?>">
          </div>
        </div>
        <div class="row g-3 mt-3">
          <div class="col-md-6">
            <label for="unidadMedida" class="form-label">Unidad de Medida</label>
            <select id="unidadMedida" name="unidadMedida" class="form-select">
              <option value="">-- Selecciona --</option>
              <?php foreach ($units as $u): ?>
                <option value="<?= $u ?>" <?= $values['unidadMedida']=== $u?'selected':'' ?>><?= ucfirst($u) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="departamento" class="form-label">Departamento</label>
            <select id="departamento" name="departamento" class="form-select">
              <option value="">-- Selecciona --</option>
              <?php foreach ($departments as $d): ?>
                <option value="<?= $d ?>" <?= $values['departamento']=== $d?'selected':'' ?>><?= $d ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="mb-3 mt-3">
          <label for="imagen_url" class="form-label">URL Imagen (opcional)</label>
          <input type="text" class="form-control" id="imagen_url" name="imagen_url" value="<?= htmlspecialchars($values['imagen_url']) ?>">
        </div>

        <button type="submit" class="btn btn-success w-100">Guardar Oferta</button>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
