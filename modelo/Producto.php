<?php
class ModeloProducto {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock ) {

        if(isset($_FILES['imagen'])) {
            $archivo_temporal = $_FILES['imagen']['tmp_name'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $ruta_destino = './image/' . $nombre_archivo;
        
          
            move_uploaded_file($archivo_temporal, $ruta_destino);
        }
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO productos (nombre_producto, id_categoria, precio, dir, stock) VALUES (:nombre_producto, :id_categoria, :precio, :dir, :stock) ");
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':dir', $ruta_destino);
        $stmt->bindParam(':stock', $stock);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showProducto($id_producto){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del producto por su ID
        $stmt = $PDO->prepare("SELECT * FROM productos 
        JOIN categoria ON categoria.id_categoria = productos.id_categoria
        WHERE productos.id_producto = :id_producto");
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarProducto($nombre_producto, $id_categoria , $precio, $ruta_destino, $stock, $id_producto){
        
        if(isset($_FILES['imagen'])) {
            $archivo_temporal = $_FILES['imagen']['tmp_name'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $ruta_destino = './image/' . $nombre_archivo;
        
          
            move_uploaded_file($archivo_temporal, $ruta_destino);
        }
        
        $stmt = $this->PDO->prepare("UPDATE productos SET nombre_producto = :nombre_producto, id_categoria = :id_categoria, precio = :precio, dir = :dir, stock = :stock WHERE id_producto = :id_producto");
        
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':dir', $ruta_destino);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':id_producto', $id_producto);
        
        
        return ($stmt->execute()) ? $id_producto : false;
    }

    public function eliminarProducto($id_producto){
        // LLAVES FORÁNEAS
        // Para eliminar el producto, se debe eliminar del carro y de las listas1

        $stmt2 = $this->PDO->prepare("DELETE FROM productos WHERE id_producto = :id_producto");
        $stmt = $this->PDO->prepare("DELETE FROM l1_productos WHERE id_producto = :id_producto");
        $stmt3 = $this->PDO->prepare("DELETE FROM carro_productos_extra WHERE id_producto = :id_producto");
        $stmt4 = $this->PDO->prepare("DELETE FROM productos_extra WHERE id_producto = :id_producto");

        $stmt->bindParam(':id_producto', $id_producto);
        $stmt2->bindParam(':id_producto', $id_producto);
        $stmt3->bindParam(':id_producto', $id_producto);
        $stmt4->bindParam(':id_producto', $id_producto);

        return ($stmt3->execute() && $stmt->execute() && $stmt4->execute() && $stmt2->execute()) ? true : false;
    }
}
?>