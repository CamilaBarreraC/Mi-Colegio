<?php
class ModeloProductoExtra {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProductoExtra($id_producto, $estado, $rut_cliente ) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO productos_extra (id_producto, estado, rut_cliente) VALUES (:id_producto, :estado, :rut_cliente) ");
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showProductoExtra($id_extras){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del curso por su ID
        $stmt = $PDO->prepare("SELECT * FROM productos_extra 
        JOIN cliente ON productos_extra.rut_cliente = cliente.rut_cliente
        JOIN productos ON productos_extra.id_producto = productos.id_producto
        WHERE productos_extra.id_extras = :id_extras");
        $stmt->bindParam(':id_extras', $id_extras);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarProductoExtra($id_producto , $estado, $rut_cliente, $id_extras){
        $stmt = $this->PDO->prepare("UPDATE productos_extra SET id_producto = :id_producto, estado = :estado, rut_cliente = :rut_cliente WHERE id_extras = :id_extras");
        
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':id_extras', $id_extras);
        
        return ($stmt->execute()) ? $id_extras : false;
    }

    public function eliminarProductoExtra($id_extras){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM productos_extra WHERE id_extras = :id_extras");
        $stmt->bindParam(':id_extras', $id_extras);
        return ($stmt->execute()) ? true : false;
    }
}
?>