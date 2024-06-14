<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controladorPagCliente/crud_alumno/controlador_alumno.php');

    $obj = new ControladorAlumno();
    $obj->actualizarAlumno($_POST['nombre_alumno'], $_POST['apellido_paterno'], $_POST['id_curso'], $_POST['rut_apoderado'], $_POST['id_alumno']);

?>