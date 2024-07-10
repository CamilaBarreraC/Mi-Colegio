<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controladorPagCliente/crud_productos_extra/controlador_productos_extra.php');

    if (isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];
        $obj = new ControladorProductoExtra();
        $obj->eliminarProductoExtra2($id_producto);
    } else {
        echo "ID de producto no fue enviado";
    }

?>