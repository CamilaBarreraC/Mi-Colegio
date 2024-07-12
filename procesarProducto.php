<?php
require_once ('controlador/crud_producto/controlador_producto.php');
include("modelo/conexion_bd.php");

// Verifica si el nombre del producto ya existe
if (isset($_POST['nombre_producto'])) {
    $nombre_producto = $_POST['nombre_producto'];
    $sql = "SELECT * FROM productos WHERE nombre_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombre_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el producto ya existe, redirige a la página con un mensaje de error
        header("Location: Productos.php?status=duplicado");
        exit();
    } else {
        // Si el producto no existe, procede a insertarlo
        $obj = new ControladorProducto();
        $obj->insertarProducto($_POST['nombre_producto'], $_POST['id_categoria'], $_POST['precio'], $_FILES['imagen'], $_POST['stock']);
        exit();
    }
} else {
    header("Location: Productos.php?status=error");
    exit();
}
?>
