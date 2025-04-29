<?php
session_start();
require_once 'includes/auth.php';

// Si el usuario ya está logueado, redirigir al panel
if (isLoggedIn()) {
    header('Location: admin/panel.php');
    exit();
}

// Si no está logueado, redirigir al login
header('Location: admin/login.php');
exit();
?>
