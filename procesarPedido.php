<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controlador/crud_pedido/controlador_pedido.php');

    $obj = new ControladorPedido();
    $obj->insertarPedido($_POST['precio_total'], $_POST['estado'], $_POST['id_medio_pago'], $_POST['rut_cliente'], $_POST['id_lista_2']);

?>