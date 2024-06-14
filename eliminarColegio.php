<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO COLEGIO EN MVC -->

<?php
    require_once ('controlador/crud_colegio/controlador_colegio.php');

    $obj = new ControladorColegio();
    $obj->eliminarColegio($_GET['id_colegio']);

?>