<?php
// service/api/ofertas.php
header('Content-Type: application/json');

// 1. Conexión a BD
require_once __DIR__ . '/../includes/db.php';

// 2. Fecha actual para filtrar
$hoy = date('Y-m-d');

// 3. Consultar ofertas activas y vigentes
$stmt = $pdo->prepare(
    "SELECT
         id,
         descripcion,
         precio_regular,
         precio_oferta,
         imagen_url,
         fecha_inicio,
         fecha_fin,
         unidad_medida,
         activo
     FROM ofertas
    WHERE activo = 1
      AND fecha_inicio <= :hoy
      AND fecha_fin    >= :hoy
    ORDER BY fecha_inicio DESC"
);
$stmt->execute([':hoy' => $hoy]);
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. Devolver JSON
echo json_encode(['ofertas' => $ofertas]);
// Asegúrate de NO imprimir nada más, ni espacios, ni saltos de línea tras esto