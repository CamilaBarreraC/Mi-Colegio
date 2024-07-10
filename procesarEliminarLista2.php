<?php
require_once ('controladorPagCliente/controlador_lista2productos/controlador_lista2productos.php');

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $obj = new ControladorLista2Productos();
    $obj->eliminarLista2Productos($id_producto);
} else {
    echo "ID de producto no fue enviado";
}
?>
