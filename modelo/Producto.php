<?php
class ModeloProducto {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino ) {

        if(isset($_FILES['imagen'])) {
            $archivo_temporal = $_FILES['imagen']['tmp_name'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $ruta_destino = './image/' . $nombre_archivo;
        
          
            move_uploaded_file($archivo_temporal, $ruta_destino);
        }
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO productos (nombre_producto, id_categoria, precio, dir) VALUES (:nombre_producto, :id_categoria, :precio, :dir) ");
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':dir', $ruta_destino);

        
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

    public function actualizarProducto($nombre_producto, $id_categoria , $precio, $ruta_destino, $id_producto){
        
        if(isset($_FILES['imagen'])) {
            $archivo_temporal = $_FILES['imagen']['tmp_name'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $ruta_destino = './image/' . $nombre_archivo;
        
          
            move_uploaded_file($archivo_temporal, $ruta_destino);
        }
        
        $stmt = $this->PDO->prepare("UPDATE productos SET nombre_producto = :nombre_producto, id_categoria = :id_categoria, precio = :precio, dir = :dir WHERE id_producto = :id_producto");
        
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':dir', $ruta_destino);
        $stmt->bindParam(':id_producto', $id_producto);
        
        
        return ($stmt->execute()) ? $id_producto : false;
    }

    public function eliminarProducto($id_producto){
        // LLAVES FORÁNEAS

        $stmt2 = $this->PDO->prepare("DELETE FROM productos WHERE id_producto = :id_producto");
        $stmt = $this->PDO->prepare("DELETE FROM l1_productos WHERE id_producto = :id_producto");
        
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt2->bindParam(':id_producto', $id_producto);
        return ($stmt->execute() && $stmt2->execute()) ? true : false;
    }
}
?>