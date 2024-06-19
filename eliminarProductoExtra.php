<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controladorPagCliente/crud_productos_extra/controlador_productos_extra.php');
    
    $obj = new ControladorProductoExtra();
    $obj->eliminarProductoExtra($_GET['id_producto']);

?>