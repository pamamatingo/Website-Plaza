-- Crea la base de datos y selecciónala
CREATE DATABASE IF NOT EXISTS mmtingoapp
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE mmtingoapp;

-- Tabla de usuarios para autenticación
CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de ofertas para promociones
CREATE TABLE IF NOT EXISTS ofertas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  descripcion VARCHAR(255) NOT NULL,
  precio_regular DECIMAL(10,2) NOT NULL,
  precio_oferta DECIMAL(10,2) NOT NULL,
  imagen_url VARCHAR(2083) NOT NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  unidad_medida VARCHAR(50),
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
