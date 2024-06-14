<?php
class ModeloProductoLista1 {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProductoLista1($id_producto, $cantidad, $id_lista_1) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO l1_productos (id_producto, cantidad, id_lista_1) VALUES (:id_producto, :cantidad, :id_lista_1) ");
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_lista_1', $id_lista_1);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showProductoLista1($id_lista_1){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos de la categoria por su ID
        $stmt = $PDO->prepare("SELECT id_lista_1_productos, l1_productos.id_producto, cantidad, l1_productos.id_lista_1,
        productos.nombre_producto, productos.precio, nombre_l1
        FROM l1_productos 
        JOIN productos ON l1_productos.id_producto = productos.id_producto
        JOIN lista_1 ON l1_productos.id_lista_1 = lista_1.id_lista_1
        WHERE l1_productos.id_lista_1 = :id_lista_1;");
        $stmt->bindParam(':id_lista_1', $id_lista_1);
        $stmt->execute();
    
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Contar el número de filas obtenidas
        $numero_filas = count($resultados);

        // Si no se encontraron resultados, devuelve false en lugar de 'error'
        if ($numero_filas > 0) {
            return $resultados;
        } else {
            // Si no se encontraron resultados, devuelve false
            return false;
        }
    }

    public function showLista1Productos($id_lista_1_productos){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos de la categoria por su ID
        $stmt = $PDO->prepare("SELECT id_lista_1_productos, l1_productos.id_producto, cantidad, l1_productos.id_lista_1,
        productos.nombre_producto, productos.precio, nombre_l1
        FROM l1_productos 
        JOIN productos ON l1_productos.id_producto = productos.id_producto
        JOIN lista_1 ON l1_productos.id_lista_1 = lista_1.id_lista_1
        WHERE l1_productos.id_lista_1_productos = :id_lista_1_productos;");
        $stmt->bindParam(':id_lista_1_productos', $id_lista_1_productos);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarProductoLista1($id_producto, $cantidad, $id_lista_1, $id_lista_1_productos){
        $stmt = $this->PDO->prepare("UPDATE l1_productos SET id_producto = :id_producto, 
        cantidad = :cantidad, id_lista_1 = :id_lista_1 
        WHERE id_lista_1_productos = :id_lista_1_productos");
        
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_lista_1', $id_lista_1);
        $stmt->bindParam(':id_lista_1_productos', $id_lista_1_productos);
        
        return ($stmt->execute()) ? $id_lista_1_productos : false;
    }

    public function eliminarProductoLista1($id_lista_1_productos){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM l1_productos 
        WHERE id_lista_1_productos = :id_lista_1_productos");
        $stmt->bindParam(':id_lista_1_productos', $id_lista_1_productos);

        //EN CASO DE LLAVES FORÁNEAS
        //$stmt2 = $this->PDO->prepare("DELETE FROM lista_1 WHERE id_lista_1 = :id_lista_1");
        //$stmt2->bindParam(':id_lista_1', $id_lista_1);

        return ($stmt->execute()) ? true : false;
    }

    public function obtenerIdLista1($id_lista_1_productos) {
        $stmt = $this->PDO->prepare("SELECT id_lista_1 FROM l1_productos WHERE id_lista_1_productos = :id_lista_1_productos");
        $stmt->bindParam(':id_lista_1_productos', $id_lista_1_productos);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['id_lista_1']; 
        // Devuelve el id_lista_1 asociado al id_lista_1_productos seleccionado
    }

    public function obtenerIdLista1Ingreso($id_lista_1_productos) {
        $stmt = $this->PDO->prepare("SELECT id_lista_1 FROM l1_productos WHERE id_lista_1_productos = :id_lista_1_productos");
        $stmt->bindParam(':id_lista_1_productos', $id_lista_1_productos);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['id_lista_1']; 
        // Devuelve el id_lista_1 asociado al id_lista_1_productos seleccionado
    }
}
?>