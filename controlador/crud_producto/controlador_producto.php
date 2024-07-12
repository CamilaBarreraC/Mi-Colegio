<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorProducto {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Producto.php');
        $this->modelo = new ModeloProducto();
        // Inicializar la conexiÃ³n PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock) {
        $this->modelo->insertarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock);
        return ($nombre_producto != false) ? header("Location: alertas/AlertasProducto/alertaIngresar.php?nombre_producto=".$nombre_producto) : header("Location: alertas/AlertasProducto/alertaIngresar.php");        

    }

    public function actualizarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock, $id_producto){
        return ($this->modelo->actualizarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock, $id_producto) != false) ? header("Location: alertas/AlertasProducto/alertaActualizar.php?id_producto=".$id_producto) : header("Location: alertas/AlertasProducto/alertaActualizar.php");
    }

    public function showProducto($id_producto){
        require_once('modelo/Producto.php');
        $modelo = new ModeloProducto();

        return $modelo->showProducto($id_producto);
    }

    public function eliminarProducto($id_producto){
        return ($this->modelo->eliminarProducto($id_producto)) ? header("Location: alertas/AlertasProducto/alertasEliminar.php") : header("Location: alertas/AlertasProducto/alertasEliminar.php?id_producto=".$id_producto);
    }
}
?>