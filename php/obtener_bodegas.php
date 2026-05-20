<?php
include("conexion.php");

// Aquí buscamos todas las bodegas
$sql = "SELECT id_bodega, nombre_bodega FROM bodegas ORDER BY nombre_bodega";
$resultado = $conexion->query($sql);

$bodegas = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve en formato JSON
echo json_encode($bodegas);