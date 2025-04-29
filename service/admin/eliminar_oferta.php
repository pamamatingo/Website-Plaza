<?php
// admin/eliminar_oferta.php

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

// Verificar token CSRF
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(400);
    exit('Token CSRF inválido.');
}

// --------------------------------------------------
// 3. Autenticación y conexión a la base de datos
// --------------------------------------------------
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
if (!isLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

// --------------------------------------------------
// 4. Eliminar la oferta
// --------------------------------------------------
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM ofertas WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

// --------------------------------------------------
// 5. Redireccionar con mensaje flash
// --------------------------------------------------
header('Location: /service/admin/ofertas.php?msg=eliminado');
exit;
