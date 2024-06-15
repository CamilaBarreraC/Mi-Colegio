<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorProductoExtra {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/ProductoExtra.php');
        $this->modelo = new ModeloProductoExtra();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProductoExtra($id_producto, $estado, $rut_cliente) {
        $this->modelo->insertarProductoExtra($id_producto, $estado, $rut_cliente);
        return ($id_producto != false) ? header("Location: alertasPagCliente/AlertasProductosExtra/alertaIngresar.php?id_producto=".$id_producto) : header("Location: alertasPagCliente/AlertasProductosExtra/alertaIngresar.php");        

    }

    public function actualizarProductoExtra($id_producto, $estado, $rut_cliente, $id_extras){
        return ($this->modelo->actualizarProductoExtra($id_producto, $estado, $rut_cliente, $id_extras) != false) ? header("Location: alertasPagCliente/AlertasProductosExtra/alertaActualizar.php?id_extras=".$id_extras) : header("Location: alertasPagCliente/AlertasProductosExtra/alertaActualizar.php");
    }

    public function showProductoExtra($id_extras){
        require_once('modelo/ProductoExtra.php');
        $modelo = new ModeloProductoExtra();

        return $modelo->showProductoExtra($id_extras);
    }

    public function eliminarProductoExtra($id_extras){
        return ($this->modelo->eliminarProductoExtra($id_extras)) ? header("Location: alertasPagCliente/AlertasProductosExtra/alertasEliminar.php") : header("Location: alertasPagCliente/AlertasProductosExtra/alertasEliminar.php?id_extras=".$id_extras);
    }
}
?>