<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controlador/crud_producto/controlador_producto.php');

    $obj = new ControladorProducto();
    $obj->actualizarProducto($_POST['nombre_producto'], $_POST['id_categoria'], $_POST['precio'], $_FILES['imagen'], $_POST['stock'], $_POST['id_producto']);

?>