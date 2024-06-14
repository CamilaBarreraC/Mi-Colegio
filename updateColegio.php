<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php

    require_once ('controlador/crud_colegio/controlador_colegio.php');

    $obj = new ControladorColegio();
    $obj->actualizarColegio($_POST['id_colegio'], $_POST['nombre_de_colegio'], $_POST['id_comuna'], $_POST['direccion']);

?>