<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
require_once ('controlador/crud_cliente/controlador_cliente.php');

$obj = new ControladorCliente();
$obj->eliminar($_GET['rut_cliente']);

?>