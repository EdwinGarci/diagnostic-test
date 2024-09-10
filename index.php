<?php
/* Llamando Cadena de Conexion */
require_once("config/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnostic Test</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="/public/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Formulario de Producto</h1>
        <form id="product_form">
            <div class="column">
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo">
                </div>
                <div class="form-group">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega" required>
                        <option label="Seleccione"></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option label="Seleccione"></option>
                    </select>
                </div>
            </div>
            <div class="column">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option label="Seleccione"></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio">
                </div>
            </div>
            <div class="form-group full-width">
                <label>Material del Producto</label>
                <div id="material-group" class="checkbox-group">
                </div>
            </div>
            <div class="form-group full-width">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>
            <button type="submit" class="btn-submit">Guardar Producto</button>
        </form>
    </div>
    <script type="text/javascript" src="index.js"></script>
</body>

</html>