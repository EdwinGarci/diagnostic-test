// Metodo de guardado
document.getElementById("product_form").addEventListener("submit", async function (e) {
    e.preventDefault(); // Prevenir el envío normal del formulario

    // Obtener los valores de los campos para validar
    var nombre = document.getElementById("nombre").value;
    var precio = document.getElementById("precio").value;

    // Validaciones
    var isCodigoValido = await validateCodigo();
    if (!isCodigoValido) {
        return;
    }

    if (!validateNombre(nombre)) {
        return;
    }

    if (!validatePrecio(precio)) {
        return;
    }

    if (!validateCheckboxes()) {
        return;
    }

    if (!validateWarehouse()) {
        return;
    }

    if (!validateCurrency()) {
        return;
    }

    if (!validateDescripcion()) {
        return;
    }

    // Crear objeto FormData
    var formData = new FormData(this);

    // Enviar la solicitud AJAX
    fetch("/controllers/product.php?op=save", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Producto guardado con éxito");
            } else {
                alert("Error al guardar el producto");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
});

// Funciones para cargar datos dinámicos
document.addEventListener("DOMContentLoaded", function () {
    combo_currencies();
    combo_warehouses();
    combo_materials();

    document.getElementById('bodega').addEventListener('change', function () {
        let id_bodega = this.value;
        if (id_bodega) {
            load_branches(id_bodega);
        } else {
            document.getElementById('sucursal').innerHTML = '<option label="Seleccione"></option>';
        }
    });
});

// Función para cargar las bodegas
function combo_warehouses() {
    fetch("/controllers/product.php?op=combo_warehouses", {
        method: "POST"
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('bodega').innerHTML = data;
        })
        .catch(error => {
            console.error("Error al cargar las bodegas:", error);
        });
}

// Función para cargar sucursales
function load_branches(id_bodega) {
    fetch("/controllers/product.php?op=get_branches_by_bodega", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_bodega=' + id_bodega
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('sucursal').innerHTML = data;
        })
        .catch(error => {
            console.error("Error al cargar las sucursales:", error);
        });
}

// Función para cargar las monedas
function combo_currencies() {
    fetch("/controllers/product.php?op=combo_currencies", {
        method: "POST"
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('moneda').innerHTML = data;
        })
        .catch(error => {
            console.error("Error al cargar las monedas:", error);
        });
}

// Función para cargar los materiales
function combo_materials() {
    fetch("/controllers/product.php?op=combo_materials", {
        method: "POST"
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('material-group').innerHTML = data;
        })
        .catch(error => {
            console.error("Error al cargar los materiales:", error);
        });
}

/** En este punto, comienzan las validaciones de los campos del formulario */

// Función para validar el nombre del producto
function validateNombre(nombre) {
    var nombre = document.getElementById("nombre").value;

    // 1. Validar si el campo está vacío
    if (!nombre) {
        alert("El nombre del producto no puede estar en blanco.");
        return false;
    }

    // 2. Validar longitud
    if (nombre.length < 2 || nombre.length > 50) {
        alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
        return false;
    }

    return true;
}

// Función para validar el precio
function validatePrecio(precio) {
    var precio = document.getElementById("precio").value;
    var precioPattern = /^\d+(\.\d{1,2})?$/;

    // 1. Validar si el campo está vacío
    if (!precio) {
        alert("El precio del producto no puede estar en blanco.");
        return false;
    }

    // 2. Validar el formato del precio
    if (!precioPattern.test(precio)) {
        alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
        return false;
    }

    return true;
}

// Función para validar el grupo de checkboxes
function validateCheckboxes() {
    var checkboxes = document.querySelectorAll('input[name="material[]"]:checked');

    if (checkboxes.length < 2) {
        alert("Debe seleccionar al menos dos materiales para el producto.");
        return false;
    }
    return true;
}

// Función para validar la descripción
function validateDescripcion() {
    var descripcion = document.getElementById("descripcion").value.trim(); // Eliminar espacios en blanco al inicio y al final

    if (descripcion === "") {
        alert("La descripción del producto no puede estar en blanco.");
        return false;
    }

    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
        return false;
    }

    return true;
}

// Función para validar la bodega
function validateWarehouse() {
    var bodega = document.getElementById("bodega").value;

    if (bodega === "") {
        alert("Debe seleccionar una bodega.");
        return false;
    }
    return true;
}

// Función para validar la sucursal seleccionada
function validateBranch() {
    var sucursal = document.getElementById("sucursal").value;

    if (sucursal === "") {
        alert("Debe seleccionar una sucursal para la bodega seleccionada.");
        return false;
    }
    return true;
}

// Función para validar la moneda seleccionada
function validateCurrency() {
    var moneda = document.getElementById("moneda").value;

    if (moneda === "") {
        alert("Debe seleccionar una moneda para el producto.");
        return false;
    }
    return true;
}

// Función para validar el formato del código
async function validateCodigo() {
    var codigo = document.getElementById("codigo").value;

    // 1. Validar si el campo está vacío
    if (!codigo) {
        alert("El código del producto no puede estar en blanco.");
        return false;
    }

    // 2. Validar longitud
    if (codigo.length < 5 || codigo.length > 15) {
        alert("El código del producto debe tener entre 5 y 15 caracteres.");
        return false;
    }

    // 3. Validar formato
    var codigoPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z0-9]{5,15}$/;
    if (!codigoPattern.test(codigo)) {
        alert("El código del producto debe contener letras y números.");
        return false;
    }

    // 4. Verificar unicidad del código (AJAX)
    var isUnique = await checkCodigoUniqueness(codigo);
    if (!isUnique) {
        alert("El código del producto ya está registrado.");
        return false;
    }

    return true; // Si todas las validaciones son correctas
}

// Función para verificar la unicidad del código
function checkCodigoUniqueness(codigo) {
    console.log(codigo)
    return fetch("/controllers/product.php?op=check_codigo", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'codigo=' + encodeURIComponent(codigo)
    })
        .then(response => response.json())
        .then(data => data.unique)
        .catch(error => {
            console.error("Error al verificar la unicidad del código:", error);
            return false;
        });
}