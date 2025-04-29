<?php
// /service/includes/auth.php

// Inicia sesión si aún no está activa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Conexión PDO
require_once __DIR__ . '/db.php';

/**
 * Intenta loguear al usuario.
 * @param string $username
 * @param string $password (texto plano)
 * @return bool true si las credenciales son válidas
 */
function login(string $username, string $password): bool {
    global $pdo;
    // Ajusta la consulta a tu tabla y columnas reales
    $stmt = $pdo->prepare('
        SELECT id, usuario, password 
        FROM usuarios 
        WHERE usuario = :u
    ');
    $stmt->execute(['u' => $username]);
    $user = $stmt->fetch();

    // Comprueba el hash (password fue almacenado con password_hash)
    if ($user && password_verify($password, $user['password'])) {
        // Guarda en sesión
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['usuario'];
        return true;
    }
    return false;
}

/**
 * @return bool true si hay sesión iniciada
 */
function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

/**
 * Cierra la sesión.
 */
function logout(): void {
    $_SESSION = [];
    session_destroy();
}
