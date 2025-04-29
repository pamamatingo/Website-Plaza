<?php
// admin/logout.php

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
// 2. Configuración de sesión segura
// --------------------------------------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);

session_start();

// --------------------------------------------------
// 3. Verificar CSRF (si se envía por POST)
// --------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        http_response_code(400);
        exit('Token CSRF inválido.');
    }
}

// --------------------------------------------------
// 4. Destruir sesión completamente
// --------------------------------------------------
// Limpiar datos de sesión
$_SESSION = [];

// Borrar cookie de sesión
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruir la sesión
session_destroy();

// --------------------------------------------------
// 5. Redireccionar a login
// --------------------------------------------------
header('Location: /service/admin/login.php');
exit;
