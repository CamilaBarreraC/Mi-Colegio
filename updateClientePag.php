<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php

    require_once ('controladorPagCliente/crud_cliente/controlador_cliente.php');
    $obj = new ControladorCliente();
    $obj->actualizar($_POST['rut_cliente'], $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['email'], $_POST['telefono'], $_POST['direccion'], $_POST['parentesco'], $_POST['id_comuna'], $_POST['clave']);

?>