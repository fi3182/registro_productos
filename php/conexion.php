<?php

// Datos de conexión a PostgreSQL
$host = "localhost";
$port = "5432";
$dbname = "registro_productos";
$user = "postgres";
$password = "MI_PASSWORD";

// Aquí se crea la conexión usando PDO
try {
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}