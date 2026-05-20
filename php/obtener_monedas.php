<?php
include("conexion.php");

// Aquí buscamos todas las monedas
$sql = "SELECT id_moneda, nombre_moneda FROM monedas ORDER BY nombre_moneda";
$resultado = $conexion->query($sql);

$monedas = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve en formato JSON
echo json_encode($monedas);