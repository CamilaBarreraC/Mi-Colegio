<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controlador/crud_lista1productos/controlador_lista1productos.php');

    $obj = new ControladorProductoLista1();
    $obj->eliminarProductoLista1($_GET['id_lista_1_productos']);

?>