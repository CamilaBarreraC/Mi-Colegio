<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controlador/crud_categoria/controlador_categoria.php');

    $obj = new ControladorCategoria();
    $obj->eliminarCategoria($_GET['id_categoria']);

?>