<?php
// Parámetros de conexión a la base de datos
$DB_HOST = 'localhost';  // Servidor local
$DB_NAME = 'mmtingoapp'; // 👉 Aquí debes poner el nombre real de tu base de datos
$DB_USER = 'root'; // Tu usuario MySQL
$DB_PASS = ']y6B>pf+Q/;'; // Tu contraseña de MySQL

// Intentar conexión usando PDO
try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    // Opciones de PDO para mejor seguridad
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
