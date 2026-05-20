<?php
include("conexion.php");

// Aquí buscamos todos los materiales disponibles
$sql = "SELECT id_material, nombre_material FROM materiales ORDER BY id_material";
$resultado = $conexion->query($sql);

$materiales = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve en formato JSON
echo json_encode($materiales);