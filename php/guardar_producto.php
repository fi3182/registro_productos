<?php
include("conexion.php");

// Aquí recibimos los datos del formulario
$codigo = $_POST["codigo"] ?? "";
$nombre = $_POST["nombre"] ?? "";
$bodega = $_POST["bodega"] ?? "";
$sucursal = $_POST["sucursal"] ?? "";
$moneda = $_POST["moneda"] ?? "";
$precio = $_POST["precio"] ?? "";
$descripcion = $_POST["descripcion"] ?? "";
$materiales = $_POST["materiales"] ?? [];

// Si falta algo, devolvemos error
if ($codigo == "" || $nombre == "" || $bodega == "" || $sucursal == "" || $moneda == "" || $precio == "" || $descripcion == "") {
    echo json_encode(["estado" => "error", "mensaje" => "Faltan datos obligatorios."]);
    exit;
}

try {

    // Aquí se inicia la transacción
    $conexion->beginTransaction();

    // Aquí se guarda el producto
    $sql = "INSERT INTO productos (codigo_producto, nombre_producto, id_bodega, id_sucursal, id_moneda, precio, descripcion)
            VALUES (:codigo, :nombre, :bodega, :sucursal, :moneda, :precio, :descripcion)
            RETURNING id_producto";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":codigo", $codigo);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":bodega", $bodega);
    $stmt->bindParam(":sucursal", $sucursal);
    $stmt->bindParam(":moneda", $moneda);
    $stmt->bindParam(":precio", $precio);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->execute();

    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_producto = $producto["id_producto"];

    // Aquí se guardan los materiales seleccionados
    foreach ($materiales as $id_material) {

        $sqlMaterial = "INSERT INTO producto_material (id_producto, id_material)
                        VALUES (:id_producto, :id_material)";

        $stmtMaterial = $conexion->prepare($sqlMaterial);
        $stmtMaterial->bindParam(":id_producto", $id_producto);
        $stmtMaterial->bindParam(":id_material", $id_material);
        $stmtMaterial->execute();
    }

    // Aquí se confirma el guardado completo
    $conexion->commit();

    echo json_encode(["estado" => "ok"]);

} catch (PDOException $e) {

    // Si algo falla, se revierte todo
    $conexion->rollBack();

    echo json_encode(["estado" => "error", "mensaje" => "No se pudo guardar el producto."]);
}