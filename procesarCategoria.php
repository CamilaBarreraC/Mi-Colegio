<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controlador/crud_categoria/controlador_categoria.php');

    $obj = new ControladorCategoria();
    $obj->insertarCategoria($_POST['nombre_categoria']);

?>