<?php
class ModeloLista2Productos {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarLista2Productos($id_producto, $cantidad, $estado, $id_curso) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO l2_productos (id_producto, cantidad, estado, id_curso) VALUES (:id_producto, :cantidad, :estado, :id_curso)");
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_curso', $id_curso);

        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showLista2Productos($id_lista_2_productos){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos de la categoria por su ID
        $stmt = $PDO->prepare("SELECT *
        FROM l2_productos 
        JOIN curso ON lista_2.id_curso = curso.id_curso
        JOIN lista_2 ON lista_2.rut_cliente = l2_productos.rut_cliente 
        JOIN cliente ON lista_2.rut_cliente = cliente.rut_cliente
        JOIN productos ON l2_productos.id_producto = productos.id_producto
        WHERE l2_productos.id_lista_2_productos = :id_lista_2_productos");
        $stmt->bindParam(':id_lista_2_productos', $id_lista_2_productos);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarLista2Productos($id_producto, $cantidad, $estado, $concepto, $rut_cliente, $id_lista_2_productos){
        $stmt = $this->PDO->prepare("UPDATE l2_productos SET id_producto = :id_producto, cantidad = :cantidad, 
        estado = :estado, concepto = :concepto, rut_cliente = :rut_cliente
        WHERE id_lista_2_productos = :id_lista_2_productos");
        
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':concepto', $concepto);
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':id_lista_2_productos', $id_lista_2_productos);
        
        return ($stmt->execute()) ? $id_lista_2_productos : false;
    }

    public function eliminarLista2Productos($id_producto){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM l2_productos 
        WHERE id_producto = :id_producto");
        $stmt->bindParam(':id_producto', $id_producto);

        //$stmt2 = $this->PDO->prepare("DELETE FROM lista_1 WHERE id_lista_1 = :id_lista_1");
        //$stmt2->bindParam(':id_lista_1', $id_lista_1);

        return ($stmt->execute()) ? true : false;
    }
}
?>