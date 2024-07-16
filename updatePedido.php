<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php

    require_once ('controlador/crud_pedido/controlador_pedido.php');

    $obj = new ControladorPedido();
    $obj->actualizarPedido($_POST['estado'], $_POST['id_pedido']);

?>