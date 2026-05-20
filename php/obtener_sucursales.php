<?php
include("conexion.php");

// Aquí recibimos la bodega seleccionada
$id_bodega = $_GET["id_bodega"] ?? "";

// Si no llega bodega, devolvemos vacío
if ($id_bodega == "") {
    echo json_encode([]);
    exit;
}

// Aquí buscamos las sucursales de esa bodega
$sql = "SELECT id_sucursal, nombre_sucursal 
        FROM sucursales 
        WHERE id_bodega = :id_bodega
        ORDER BY nombre_sucursal";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(":id_bodega", $id_bodega);
$stmt->execute();

$sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se devuelve en formato JSON
echo json_encode($sucursales);