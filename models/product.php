<?php
    class Product extends Connect{
        /* Funcion para insertar producto */
        public function insert_product($codigo, $nombre, $id_bodega, $id_sucursal, $id_moneda, $precio, $descripcion){
            $conectar = parent::getConnection();
            parent::set_names();
            
            $sql = "INSERT INTO products (code, name, price, description, id_warehouse, id_branch, id_currency) 
                    VALUES (?, ?, ?, ?, ?, ?, ?);";
            $sql = $conectar->prepare($sql);
    
            $sql->bindValue(1, $codigo);
            $sql->bindValue(2, $nombre);
            $sql->bindValue(3, $precio);
            $sql->bindValue(4, $descripcion);
            $sql->bindValue(5, $id_bodega);
            $sql->bindValue(6, $id_sucursal);
            $sql->bindValue(7, $id_moneda);
    
            if ($sql->execute()) {
                return $conectar->lastInsertId();
            } else {
                return false;
            }
        }

        /* Function para insertar materiales de sus productos */
        public function insert_product_material($product_id, $id_material){
            $conectar = parent::getConnection();
            parent::set_names();
            
            $sql = "INSERT INTO product_material (product_id, material_id) VALUES (?, ?);";
            $sql = $conectar->prepare($sql);
    
            $sql->bindValue(1, $product_id);
            $sql->bindValue(2, $id_material);
    
            return $sql->execute();
        }

        /* Listar todas las monedas */
        public function get_currencies(){
            $conectar = parent::getConnection();
            parent::set_names();
            $sql="SELECT * FROM currencies";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* Listar todas los materiales */
        public function get_materials(){
            $conectar = parent::getConnection();
            parent::set_names();
            $sql="SELECT * FROM materials";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* Listar todas las bodegas */
        public function get_warehouses(){
            $conectar = parent::getConnection();
            parent::set_names();
            $sql="SELECT * FROM warehouses";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* Listar todas las sucursales */
        public function get_branches_by_bodega($id_bodega) {
            $conectar = parent::getConnection();
            $sql = "SELECT id, name FROM branches WHERE id_warehouse = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_bodega);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        // Método para verificar si el código es único
        public function checkCodigoUnico($codigo) {
            $conectar = parent::getConnection();
            $sql = "SELECT COUNT(*) FROM products WHERE code = :codigo";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        
    }
?>