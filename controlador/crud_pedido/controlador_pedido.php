<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorPedido {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Pedido.php');
        $this->modelo = new ModeloPedido();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarPedido($precio_total, $estado, $id_medio_pago, $rut_cliente, $id_lista_2) {
        $this->modelo->insertarPedido($precio_total, $estado, $id_medio_pago, $rut_cliente, $id_lista_2);
        return ($rut_cliente != false) ? header("Location: alertas/AlertasPedidos/alertaInsertar.php?id_pedido=".$rut_cliente) : header("Location: alertas/AlertasPedidos/alertaInsertar.php");        

    }

    public function actualizarPedido($precio_total, $estado, $id_medio_pago, $rut_cliente, $id_lista_2, $id_pedido){
        return ($this->modelo->actualizarPedido($precio_total, $estado, $id_medio_pago, $rut_cliente, $id_lista_2, $id_pedido) != false) ? header("Location: alertas/AlertasPedidos/alertaActualizar.php?id_pedido=".$id_pedido) : header("Location: alertas/AlertasPedidos/alertaActualizar.php");
    }

    public function showPedido($id_pedido){
        require_once('modelo/Pedido.php');
        $modelo = new ModeloPedido();

        return $modelo->showPedido($id_pedido);
    }

    public function eliminarPedido($id_pedido){
        return ($this->modelo->eliminarPedido($id_pedido)) ? header("Location: alertas/AlertasPedidos/alertaEliminar.php") : header("Location: alertas/AlertasPedidos/alertaEliminar.php?id_pedido=".$id_pedido);
    }
}
?>