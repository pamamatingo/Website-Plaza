<?php
// admin/dashboard.php

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
// 2. CONFIGURACIÓN DE SESIÓN SEGURA
// --------------------------------------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);

session_start();

// --------------------------------------------------
// 3. TOKEN CSRF
// --------------------------------------------------
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --------------------------------------------------
// 4. AUTENTICACIÓN
// --------------------------------------------------
require_once __DIR__ . '/../includes/auth.php';
if (!isLoggedIn()) {
    header('Location: /service/admin/login.php');
    exit;
}

// --------------------------------------------------
// 5. DATOS PARA LA VISTA
// --------------------------------------------------
$username   = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
$csrf_token = $_SESSION['csrf_token'];

// --------------------------------------------------
// 6. Incluir barra de navegación centralizada
// --------------------------------------------------
require_once __DIR__ . '/../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administrativo – Plaza Mamá Tingó</title>

    <!-- SEO Básico -->
    <meta name="description" content="Panel administrativo de Plaza Mamá Tingó.">
    <link rel="canonical" href="https://tusitio.com/admin/dashboard.php">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <a href="#main-content" class="visually-hidden-focusable">Saltar al contenido principal</a>

    <!-- La barra de navegación se carga desde includes/navbar.php -->

    <!-- Contenido principal -->
    <main id="main-content" class="container">
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body py-5">
                        <div class="card-icon mb-3">📋</div>
                        <h5 class="card-title">Ver Ofertas</h5>
                        <p class="card-text">Listado completo de ofertas.</p>
                        <a href="/service/admin/ofertas.php" class="btn btn-primary">Ir a Ofertas</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body py-5">
                        <div class="card-icon mb-3">➕</div>
                        <h5 class="card-title">Crear Oferta</h5>
                        <p class="card-text">Agregar nueva oferta.</p>
                        <a href="/service/admin/nueva_oferta.php" class="btn btn-success">Crear Oferta</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS con defer para no bloquear render -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
