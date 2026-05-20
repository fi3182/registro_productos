<?php
// Este archivo solo muestra el formulario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Productos</title>
    <link rel="stylesheet" href="css/estilos_form.css">
</head>
<body>

    <div class="contenedor">
        <h2>Formulario de Registro de Productos</h2>

        <form id="formProducto">

            <div class="fila-doble">
                <div class="fila">
                    <label for="codigo">Código del Producto</label>
                    <input type="text" id="codigo" name="codigo">
                </div>

                <div class="fila">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre">
                </div>
            </div>

            <div class="fila-doble">
                <div class="fila">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega">
                        <option value=""></option>
                    </select>
                </div>

                <div class="fila">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="fila-doble">
                <div class="fila">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option value=""></option>
                    </select>
                </div>

                <div class="fila">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio">
                </div>
            </div>

            <div class="fila">
                <label>Material del Producto</label>
                <div class="materiales" id="materiales">
                    <!-- Aquí se cargarán los materiales desde JS -->
                </div>
            </div>

            <div class="fila">
                <label for="descripcion">Descripción del Producto</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="fila">
                <button type="button" id="btnGuardar">Guardar Producto</button>
            </div>

        </form>
    </div>

    <script src="js/app.js"></script>

</body>
</html>