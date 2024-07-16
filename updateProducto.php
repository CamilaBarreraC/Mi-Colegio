<?php
// Verificar si se ha enviado el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include("modelo\conexion_bd.php");

    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $id_categoria = $_POST['id_categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen_actual = $_POST['imagen_actual']; // URL de la imagen actual

    // Verificar si se seleccionó una nueva imagen
    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener información del archivo subido
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_tamano = $_FILES['imagen']['size'];

        // Guardar la nueva imagen en el directorio deseado
        $directorio_imagenes = "ruta/donde/se/guardan/las/imagenes/";
        $ruta_imagen_nueva = $directorio_imagenes . $imagen_nombre;

        if (move_uploaded_file($imagen_tmp, $ruta_imagen_nueva)) {
            // Actualizar el registro en la base de datos con la nueva imagen
            $sql = "UPDATE productos SET nombre_producto = '$nombre_producto', id_categoria = '$id_categoria', precio = '$precio', stock = '$stock', imagen = '$ruta_imagen_nueva' WHERE id_producto = $id_producto";

            if ($conexion->query($sql) === TRUE) {
                // Eliminar la imagen anterior si es diferente de la nueva
                if ($imagen_actual != $ruta_imagen_nueva) {
                    if (file_exists($imagen_actual)) {
                        unlink($imagen_actual);
                    }
                }
                // Redireccionar a la página de productos con mensaje de éxito
                header("Location: Productos.php?actualizado=1");
                exit();
            } else {
                echo "Error al actualizar el producto: " . $conexion->error;
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        // Si no se seleccionó una nueva imagen, actualizar sin cambiar la imagen
        $sql = "UPDATE productos SET nombre_producto = '$nombre_producto', id_categoria = '$id_categoria', precio = '$precio', stock = '$stock' WHERE id_producto = $id_producto";

        if ($conexion->query($sql) === TRUE) {
            // Redireccionar a la página de productos con mensaje de éxito
            header("Location: Productos.php?actualizado=1");
            exit();
        } else {
            echo "Error al actualizar el producto: " . $conexion->error;
        }
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si no es una solicitud POST, redirigir a la página de productos o mostrar un mensaje de error
    header("Location: Productos.php?error=1");
    exit();
}
?>
