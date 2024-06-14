<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php

    require_once ('controladorPagCliente/controlador_lista2productos/controlador_lista2productos.php');

    $obj = new ControladorLista2Productos();
    $obj->actualizarLista2Productos($_POST['id_producto'], $_POST['cantidad'], $_POST['estado'], $_POST['concepto'], $_POST['rut_cliente'], $_POST['id_lista_2_productos']);

?>