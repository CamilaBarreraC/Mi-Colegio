<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
    require_once ('controladorPagCliente/crud_productos_extra/controlador_productos_extra.php');   
    
    $obj = new ControladorProductoExtra();
    $obj->insertarProductoExtra($_POST['id_producto'], $_POST['cantidad'], $_POST['estado'], $_POST['rut_cliente']);

    $stmt2 = $this->PDO->prepare("INSERT INTO carro_productos_extra (id_producto, cantidad, estado, rut_cliente) VALUES (:id_producto, :cantidad, :estado, :rut_cliente) ");
    $stmt2->bindParam(':id_producto', $id_producto);
    $stmt2->bindParam(':cantidad', $cantidad);
    $stmt2->bindParam(':estado', $estado);
    $stmt2->bindParam(':rut_cliente', $rut_cliente);

?>