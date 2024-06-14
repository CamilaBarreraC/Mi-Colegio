<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controlador/crud_lista1productos/controlador_lista1productos.php');

    $obj = new ControladorProductoLista1();
    $obj->insertarProductoLista1($_POST['id_producto'], $_POST['cantidad'], $_POST['id_lista_1']);

?>