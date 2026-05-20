<?php
include("conexion.php");

$codigo = $_GET["codigo"] ?? "";

// Aquí revisamos si el código ya existe
$sql = "SELECT COUNT(*) as total FROM productos WHERE codigo_producto = :codigo";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":codigo", $codigo);
$stmt->execute();

$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado["total"] > 0) {
    echo json_encode(["existe" => true]);
} else {
    echo json_encode(["existe" => false]);
}