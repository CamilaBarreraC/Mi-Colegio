<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

session_start();

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

    public function insertarProductoExtra($id_producto, $cantidad, $estado, $rut_cliente) {
        $id_producto_extra = $this->modelo->insertarProductoExtra($id_producto, $cantidad, $estado, $rut_cliente);
        
        if ($id_producto_extra) {
            // Agregar el ID al array en $_SESSION
            $_SESSION['producto_extra_ids'][] = $id_producto_extra;

            // Redireccionar con el ID del producto extra insertado
            header("Location: alertasPagCliente/AlertasProductosExtra/alertaIngresar.php?id_producto=$id_producto_extra");
            exit();
        } else {
            // Manejo de error si la inserción falla
            header("Location: alertasPagCliente/AlertasProductosExtra/alertaIngresar.php");
            exit();
        }
    }

    public function actualizarProductoExtra($id_producto , $cantidad , $estado, $rut_cliente, $id_extras){
        return ($this->modelo->actualizarProductoExtra($id_producto , $cantidad , $estado, $rut_cliente, $id_extras) != false) ? header("Location: alertasPagCliente/AlertasProductosExtra/alertaActualizar.php?id_extras=".$id_extras) : header("Location: alertasPagCliente/AlertasProductosExtra/alertaActualizar.php");
    }

    public function showProductoExtra($id_extras){
        require_once('modelo/ProductoExtra.php');
        $modelo = new ModeloProductoExtra();

        return $modelo->showProductoExtra($id_extras);
    }

    public function eliminarProductoExtra($id_producto){
        // Llamar a la función del modelo para eliminar el producto del carrito
        $deleted = $this->modelo->eliminarProductoExtra($id_producto);

        // Verificar si se eliminó correctamente del carrito
        if ($deleted) {
            // Eliminar el ID del producto del carrito del array en $_SESSION
            $key = array_search($id_producto, $_SESSION['producto_extra_ids']);
            if ($key !== false) {
                unset($_SESSION['producto_extra_ids'][$key]);
            }
            header("Location: alertasPagCliente/AlertasProductosExtra/alertasEliminar.php");
        } else {
            header("Location: alertasPagCliente/AlertasProductosExtra/alertasEliminar.php?id_producto=$id_producto");
        }
        exit();    
    }

    public function eliminarProductoExtra2($id_producto){
        return ($this->modelo->eliminarProductoExtra2($id_producto)) ? header("Location: alertasPagCliente/AlertasProductosExtra/alertasEliminar.php") : header("Location: alertasPagCliente/AlertasProductosExtra/alertasEliminar.php?id_producto=".$id_producto);
    }
}
?>