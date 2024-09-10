<?php
    // Llamando a cadena de Conexion
    require_once("../config/connection.php");
    // Llamando a la clase
    require_once("../models/product.php");

    // Inicializando Clase
    $product = new Product();

    // Opcion de solicitud de controller
    switch($_GET["op"]){
        // Guardar un producto
        case "save":
            if (!isset($_POST["codigo"]) || !isset($_POST["nombre"]) || !isset($_POST["bodega"]) || !isset($_POST["sucursal"]) || !isset($_POST["moneda"]) || !isset($_POST["precio"]) || !isset($_POST["descripcion"])) {
                echo json_encode(['error' => 'Faltan datos obligatorios']);
                exit();
            }

            try {
                $product_id = $product->insert_product(
                    $_POST["codigo"],
                    $_POST["nombre"],
                    $_POST["bodega"],
                    $_POST["sucursal"],
                    $_POST["moneda"],
                    $_POST["precio"],
                    $_POST["descripcion"]
                );
                if ($product_id) {
                    // Verificar si hay materiales seleccionados
                    if (isset($_POST['material']) && is_array($_POST['material'])) {
                        // Insertar cada material asociado al producto
                        foreach ($_POST['material'] as $material) {
                            $product->insert_product_material($product_id, $material);
                        }
                    }
        
                    echo json_encode(['success' => true, 'message' => 'Producto guardado con éxito']);
                } else {
                    echo json_encode(['error' => 'Error al guardar el producto']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al guardar el producto: ' . $e->getMessage()]);
            }
        break;

        // Cargar opciones para el select de monedas
        case "combo_currencies":
            try {
                $datos = $product->get_currencies();
                if (is_array($datos) && count($datos) > 0) {
                    $html = "<option label='Seleccione'></option>";
                    foreach ($datos as $row) {
                        $html .= "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    echo $html;
                } else {
                    echo "<option label='No hay monedas disponibles'></option>";
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al cargar monedas: ' . $e->getMessage()]);
            }
        break;

        // Cargar opciones para el select de bodegas
        case "combo_warehouses":
            try {
                $datos = $product->get_warehouses();
                if (is_array($datos) && count($datos) > 0) {
                    $html = "<option label='Seleccione'></option>";
                    foreach ($datos as $row) {
                        $html .= "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    echo $html;
                } else {
                    echo "<option label='No hay bodegas disponibles'></option>";
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al cargar bodegas: ' . $e->getMessage()]);
            }
        break;

        // Cargar opciones para el checkbox de materiales
        case "combo_materials":
            try {
                $datos = $product->get_materials();
                if (is_array($datos) && count($datos) > 0) {
                    $html = "";
                    foreach ($datos as $row) {
                        $html .= "
                        <input type='checkbox' id='material_".$row['id']."' name='material[]' value='".$row['id']."'>
                        <label for='material_".$row['id']."'>".$row['name']."</label><br>";
                    }
                    echo $html;
                } else {
                    echo "<p>No hay materiales disponibles</p>";
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al cargar materiales: ' . $e->getMessage()]);
            }
        break;

        // Cargar opciones para el select de sucursales
        case "get_branches_by_bodega":
            if(isset($_POST["id_bodega"])) {
                $datos = $product->get_branches_by_bodega($_POST["id_bodega"]);
                if(is_array($datos) && count($datos) > 0){
                    $html = "<option label='Seleccione'></option>";
                    foreach($datos as $row){
                        $html .= "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    echo $html;
                } else {
                    echo "<option label='No hay sucursales disponibles'></option>";
                }
            }
        break;

        case "check_codigo":
            if (isset($_POST['codigo'])) {
                $codigo = $_POST['codigo'];
        
                $result = $product->checkCodigoUnico($codigo);
        
                if ($result) {
                    echo json_encode(['unique' => false]);
                } else {
                    echo json_encode(['unique' => true]);
                }
            } else {
                echo json_encode(['error' => 'No se ha enviado el código']);
            }
        break;

        // Caso por defecto si la operación no es válida
        default:
            echo json_encode(['error' => 'Operación no válida']);
        break;
    }
?>