<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controlador/crud_pedido/controlador_pedido.php');

    $obj = new ControladorPedido();
    $obj->eliminarPedido($_GET['id_pedido']);

?>