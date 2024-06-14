<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controlador/crud_producto/controlador_producto.php');

    $obj = new ControladorProducto();
    $obj->eliminarProducto($_GET['id_producto']);

?>