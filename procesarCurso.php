<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controlador/crud_curso/controlador_curso.php');

    $obj = new ControladorCurso();
    $obj->insertarCurso($_POST['nombre_curso'], $_POST['cantidad_alumnos'], $_POST['id_colegio']);

?>