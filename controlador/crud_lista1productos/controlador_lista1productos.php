<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorProductoLista1 {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/ProductoLista1.php');
        $this->modelo = new ModeloProductoLista1();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProductoLista1($id_producto, $cantidad, $id_lista_1) {
        $this->modelo->insertarProductoLista1($id_producto, $cantidad, $id_lista_1);
        return ($id_lista_1 != false) ? header("Location: alertas/AlertasLista1Productos/alertaIngresar.php?id_lista_1=".$id_lista_1) : header("Location: alertas/AlertasLista1Productos/alertaIngresar.php");        

    }

    public function actualizarProductoLista1($id_producto, $cantidad, $id_lista_1, $id_lista_1_productos){
        $id_lista_1 = $this->modelo->obtenerIdLista1($id_lista_1_productos); 
        // Obtiene el id_lista_1 asociado al producto eliminado, 
        // para retornarlo a la página productoLista1.php
        // Entonces envía los dos parámetros, uno para verificar que se eliminó el producto
        // y el otro para volver a mostrar todos los productos asociado al id_lista_1
        $url = "alertas/AlertasLista1Productos/alertaActualizar.php?id_lista_1_productos=$id_lista_1_productos&id_lista_1=$id_lista_1";
        return ($this->modelo->actualizarProductoLista1($id_producto, $cantidad, $id_lista_1, $id_lista_1_productos)) ? header("Location: $url") : header("Location: alertas/AlertasLista1Productos/alertaActualizar.php?id_lista_1=$id_lista_1");
    }

    public function showProductoLista1($id_lista_1_productos){
        require_once('modelo/ProductoLista1.php');
        $modelo = new ModeloProductoLista1();

        return $modelo->showProductoLista1($id_lista_1_productos);
    }

    public function showLista1Productos($id_lista_1_productos){
        require_once('modelo/ProductoLista1.php');
        $modelo = new ModeloProductoLista1();

        return $modelo->showLista1Productos($id_lista_1_productos);
    }

    public function eliminarProductoLista1($id_lista_1_productos){
        $id_lista_1 = $this->modelo->obtenerIdLista1($id_lista_1_productos); 
        // Obtiene el id_lista_1 asociado al producto eliminado, 
        // para retornarlo a la página productoLista1.php
        // Entonces envía los dos parámetros, uno para verificar que se eliminó el producto
        // y el otro para volver a mostrar todos los productos asociado al id_lista_1
        $url = "alertas/AlertasLista1Productos/alertasEliminar.php?id_lista_1_productos=$id_lista_1_productos&id_lista_1=$id_lista_1";
        return ($this->modelo->eliminarProductoLista1($id_lista_1_productos)) ? header("Location: alertas/AlertasLista1Productos/alertasEliminar.php?id_lista_1=$id_lista_1") : header("Location: $url");
    }
}
?>