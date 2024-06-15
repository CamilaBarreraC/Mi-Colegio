
<?php

    require_once ('controladorPagCliente/crud_productos_extra/controlador_productos_extra.php');
        
        
    $obj = new ControladorProductoExtra();
    $obj->actualizarProductoExtra($_POST['id_producto'], $_POST['cantidad'], $_POST['estado'], $_POST['rut_cliente'], $_POST['id_extras']);

?>