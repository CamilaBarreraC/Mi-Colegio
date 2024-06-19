<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO PEDIDO EN MVC -->

<?php
    require_once ('controladorPagCliente/controlador_lista2productos/controlador_lista2productos.php');

    $obj = new ControladorLista2Productos();
    $obj->eliminarLista2Productos($_GET['id_producto']);

?>