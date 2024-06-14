<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controlador/crud_curso/controlador_curso.php');

    $obj = new ControladorCurso();
    $obj->eliminarCurso($_GET['id_curso']);

?>