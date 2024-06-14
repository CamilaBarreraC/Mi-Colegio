<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controlador/crud_lista1/controlador_lista1.php');

    $obj = new ControladorLista1();
    $obj->eliminarLista1($_GET['id_lista_1']);

?>