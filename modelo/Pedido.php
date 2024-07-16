<?php
class ModeloPedido {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarPedido($precio_total, $estado, $id_medio_pago, $rut_cliente, $id_lista_2) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO pedido (precio_total, estado, id_medio_pago, rut_cliente, id_lista_2) VALUES (:precio_total, :estado, :id_medio_pago, :rut_cliente, :id_lista_2) ");
        $stmt->bindParam(':precio_total', $precio_total);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_medio_pago', $id_medio_pago);
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':id_lista_2', $id_lista_2);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showPedido($id_pedido){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del pedido por su ID
        $stmt = $PDO->prepare("SELECT * FROM pedido JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente WHERE id_pedido = :id_pedido");
        $stmt->bindParam(':id_pedido', $id_pedido);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPedido($precio_total, $estado, $id_medio_pago, $rut_cliente, $id_lista_2, $id_pedido){
        $stmt = $this->PDO->prepare("UPDATE pedido SET precio_total = :precio_total, estado = :estado, id_medio_pago = :id_medio_pago, rut_cliente = :rut_cliente, id_lista_2 = :id_lista_2 WHERE id_pedido = :id_pedido");
        
        $stmt->bindParam(':precio_total', $precio_total);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_medio_pago', $id_medio_pago);
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':id_lista_2', $id_lista_2);
        $stmt->bindParam(':id_pedido', $id_pedido);
        
        return ($stmt->execute()) ? $id_pedido : false;
    }

    public function eliminarPedido($id_pedido){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM pedido WHERE id_pedido = :id_pedido");
        $stmt->bindParam(':id_pedido', $id_pedido);

        $stmt2 = $this->PDO->prepare("DELETE FROM detalle_pedido WHERE id_pedido = :id_pedido");
        $stmt2->bindParam(':id_pedido', $id_pedido);

        return ($stmt2->execute() && $stmt->execute()) ? true : false;
    }
}
?>