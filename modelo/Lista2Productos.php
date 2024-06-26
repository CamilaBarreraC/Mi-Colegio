<?php
class ModeloLista2Productos {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarLista2Productos($id_producto, $cantidad, $estado, $rut_cliente, $id_lista_2, $id_carro) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO l2_productos (id_producto, cantidad, estado, id_lista_2) VALUES (:id_producto, :cantidad, :estado, :id_lista_2)");
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_lista_2', $id_lista_2);

        $stmt2 = $this->PDO->prepare("INSERT INTO carro_productos (id_producto, cantidad, estado, id_carro) VALUES (:id_producto, :cantidad, :estado, :id_carro)");
        $stmt2->bindParam(':id_producto', $id_producto);
        $stmt2->bindParam(':cantidad', $cantidad);
        $stmt2->bindParam(':estado', $estado);
        $stmt2->bindParam(':id_carro', $id_carro);

        return ($stmt->execute() && $stmt2->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showLista2Productos($id_lista_2_productos){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos de la categoria por su ID
        $stmt = $PDO->prepare("SELECT *
        FROM l2_productos 
        JOIN curso ON lista_2.rut_cliente = curso.rut_cliente
        JOIN lista_2 ON lista_2.id_lista_2 = l2_productos.id_lista_2 
        JOIN cliente ON lista_2.rut_cliente = cliente.rut_cliente
        JOIN productos ON l2_productos.id_producto = productos.id_producto
        WHERE l2_productos.id_lista_2_productos = :id_lista_2_productos");
        $stmt->bindParam(':id_lista_2_productos', $id_lista_2_productos);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarLista2Productos($id_producto, $cantidad, $estado, $concepto, $id_lista_2, $id_lista_2_productos){
        $stmt = $this->PDO->prepare("UPDATE l2_productos SET id_producto = :id_producto, cantidad = :cantidad, 
        estado = :estado, concepto = :concepto, id_lista_2 = :id_lista_2
        WHERE id_lista_2_productos = :id_lista_2_productos");
        
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':concepto', $concepto);
        $stmt->bindParam(':id_lista_2', $id_lista_2);
        $stmt->bindParam(':id_lista_2_productos', $id_lista_2_productos);

        $stmt2 = $this->PDO->prepare("UPDATE carro_productos SET id_producto = :id_producto, cantidad = :cantidad, 
        estado = :estado, id_carro = :id_carro
        WHERE id_carro = :id_carro");
        
        $stmt2->bindParam(':id_producto', $id_producto);
        $stmt2->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':estado', $estado);
        $stmt2->bindParam(':id_carro', $id_carro);
        $stmt2->bindParam(':id_lista_2_productos', $id_lista_2_productos);
        
        return ($stmt->execute()) ? $id_lista_2_productos : false;
    }

    public function eliminarLista2Productos($id_producto){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM l2_productos 
        WHERE id_producto = :id_producto");
        $stmt->bindParam(':id_producto', $id_producto);

        $stmt2 = $this->PDO->prepare("DELETE FROM carro_productos 
        WHERE id_producto = :id_producto");
        $stmt2->bindParam(':id_producto', $id_producto);

        return ($stmt->execute() && $stmt2->execute()) ? true : false;
    }
}
?>