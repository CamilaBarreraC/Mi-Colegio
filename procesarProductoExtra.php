<?php
session_start(); // Inicia la sesión si no está iniciada aún
require_once('controladorPagCliente/crud_productos_extra/controlador_productos_extra.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto']) && isset($_POST['cantidad']) && isset($_POST['estado']) && isset($_POST['rut_cliente'])) {
    $controladorProductoExtra = new ControladorProductoExtra();

    // Obtener los datos
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $estado = $_POST['estado'];
    $rut_cliente = $_POST['rut_cliente'];

    $controladorProductoExtra->insertarProductoExtra($id_producto, $cantidad, $estado, $rut_cliente);
} else {
    echo "Error: No se recibieron todos los datos necesarios.";
}
?>
