<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controladorPagCliente/crud_alumno/controlador_alumno.php');

    $obj = new ControladorAlumno();
    $obj->eliminarAlumno($_GET['id_alumno']);

?>