// Aquí se cargan las bodegas al iniciar
window.onload = function () {
    cargarBodegas();
    cargarMonedas();
    cargarMateriales();
};

// Aquí cargamos bodegas desde PHP
function cargarBodegas() {
    fetch("php/obtener_bodegas.php")
        .then(response => response.json())
        .then(data => {
            let selectBodega = document.getElementById("bodega");
            selectBodega.innerHTML = '<option value=""></option>';

            data.forEach(bodega => {
                let option = document.createElement("option");
                option.value = bodega.id_bodega;
                option.textContent = bodega.nombre_bodega;
                selectBodega.appendChild(option);
            });
        });
}

// Aquí cargamos monedas desde PHP
function cargarMonedas() {
    fetch("php/obtener_monedas.php")
        .then(response => response.json())
        .then(data => {
            let selectMoneda = document.getElementById("moneda");
            selectMoneda.innerHTML = '<option value=""></option>';

            data.forEach(moneda => {
                let option = document.createElement("option");
                option.value = moneda.id_moneda;
                option.textContent = moneda.nombre_moneda;
                selectMoneda.appendChild(option);
            });
        });
}

// Cuando cambia la bodega, se cargan las sucursales
document.getElementById("bodega").addEventListener("change", function () {
    cargarSucursales(this.value);
});

// Aquí cargamos sucursales según bodega
function cargarSucursales(idBodega) {
    let selectSucursal = document.getElementById("sucursal");
    selectSucursal.innerHTML = '<option value=""></option>';

    if (idBodega === "") {
        return;
    }

    fetch("php/obtener_sucursales.php?id_bodega=" + idBodega)
        .then(response => response.json())
        .then(data => {
            data.forEach(sucursal => {
                let option = document.createElement("option");
                option.value = sucursal.id_sucursal;
                option.textContent = sucursal.nombre_sucursal;
                selectSucursal.appendChild(option);
            });
        });
}

// Aquí cargamos los materiales en checkboxes
function cargarMateriales() {
    fetch("php/obtener_materiales.php")
        .then(response => response.json())
        .then(data => {
            let contenedor = document.getElementById("materiales");
            contenedor.innerHTML = "";

            data.forEach(material => {
                let label = document.createElement("label");

                let checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "materiales[]";
                checkbox.value = material.id_material;

                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(material.nombre_material));

                contenedor.appendChild(label);
            });
        });
}

// Cuando se presiona el botón Guardar
document.getElementById("btnGuardar").addEventListener("click", function () {
    validarFormulario();
});

// Aquí se valida todo antes de enviar
function validarFormulario() {

    let codigo = document.getElementById("codigo").value.trim();
    let nombre = document.getElementById("nombre").value.trim();
    let bodega = document.getElementById("bodega").value;
    let sucursal = document.getElementById("sucursal").value;
    let moneda = document.getElementById("moneda").value;
    let precio = document.getElementById("precio").value.trim();
    let descripcion = document.getElementById("descripcion").value.trim();

    // Validación código vacío
    if (codigo === "") {
        alert("El código del producto no puede estar en blanco.");
        return;
    }

    // Validación código largo
    if (codigo.length < 5 || codigo.length > 15) {
        alert("El código del producto debe tener entre 5 y 15 caracteres.");
        return;
    }

    // Validación código formato (letras y números)
    let regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/;
    if (!regexCodigo.test(codigo)) {
        alert("El código del producto debe contener letras y números");
        return;
    }

    // Validación nombre vacío
    if (nombre === "") {
        alert("El nombre del producto no puede estar en blanco.");
        return;
    }

    // Validación nombre largo
    if (nombre.length < 2 || nombre.length > 50) {
        alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
        return;
    }

    // Validación bodega
    if (bodega === "") {
        alert("Debe seleccionar una bodega.");
        return;
    }

    // Validación sucursal
    if (sucursal === "") {
        alert("Debe seleccionar una sucursal para la bodega seleccionada.");
        return;
    }

    // Validación moneda
    if (moneda === "") {
        alert("Debe seleccionar una moneda para el producto.");
        return;
    }

    // Validación precio vacío
    if (precio === "") {
        alert("El precio del producto no puede estar en blanco.");
        return;
    }

    // Validación precio formato
    let regexPrecio = /^\d+(\.\d{1,2})?$/;
    if (!regexPrecio.test(precio)) {
        alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
        return;
    }

    // Validación materiales (mínimo 2)
    let materialesSeleccionados = document.querySelectorAll('input[name="materiales[]"]:checked');
    if (materialesSeleccionados.length < 2) {
        alert("Debe seleccionar al menos dos materiales para el producto.");
        return;
    }

    // Validación descripción vacía
    if (descripcion === "") {
        alert("La descripción del producto no puede estar en blanco.");
        return;
    }

    // Validación descripción largo
    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
        return;
    }

    // Si todo está OK, validamos que el código no exista en BD
    validarCodigoUnico(codigo);
}


// Aquí validamos si el código ya existe en la base de datos
function validarCodigoUnico(codigo) {

    fetch("php/validar_codigo.php?codigo=" + encodeURIComponent(codigo))
        .then(response => response.json())
        .then(data => {

            if (data.existe === true) {
                alert("El código del producto ya está registrado.");
                return;
            }

            // Si no existe, recién se guarda
            guardarProducto();
        });
}


// Aquí se envían los datos al PHP para guardarlos
function guardarProducto() {

    let form = document.getElementById("formProducto");
    let formData = new FormData(form);

    fetch("php/guardar_producto.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {

            if (data.estado === "ok") {
                alert("Producto guardado correctamente.");
                form.reset();

                // Se limpian sucursales y se recargan materiales
                document.getElementById("sucursal").innerHTML = '<option value=""></option>';
                cargarMateriales();
            } else {
                alert("Error: " + data.mensaje);
            }
        });
}