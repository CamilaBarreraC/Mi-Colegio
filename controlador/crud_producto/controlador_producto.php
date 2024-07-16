<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorProducto {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Producto.php');
        $this->modelo = new ModeloProducto();
        // Inicializar la conexiÃ³n PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock) {
        $this->modelo->insertarProducto($nombre_producto , $id_categoria , $precio, $ruta_destino, $stock);
        return ($nombre_producto != false) ? header("Location: alertas/AlertasProducto/alertaIngresar.php?nombre_producto=".$nombre_producto) : header("Location: alertas/AlertasProducto/alertaIngresar.php");        

    }

    public function actualizarProducto($nombre_producto, $id_categoria, $precio, $imagen, $stock, $id_producto) {
        // Obtener la ruta actual de la imagen del producto si no se sube una nueva imagen
        if ($imagen !== null && $imagen['error'] === UPLOAD_ERR_OK) {
            // Se ha seleccionado una nueva imagen, procesar y guardar la nueva imagen
            $ruta_destino = $this->guardarImagen($imagen);
        } else {
            // No se ha subido una nueva imagen, mantener la ruta de la imagen existente
            $producto = $this->showProducto($id_producto);
            $ruta_destino = $producto['dir'];
        }

        // Actualizar el producto en la base de datos
        return ($this->modelo->actualizarProducto($nombre_producto, $id_categoria, $precio, $ruta_destino, $stock, $id_producto) != false) ? header("Location: alertas/AlertasProducto/alertaActualizar.php?id_producto=".$id_producto) : header("Location: alertas/AlertasProducto/alertaActualizar.php");
    }

    // Método para guardar la imagen y obtener su ruta
    private function guardarImagen($imagen) {
        // Directorio donde se almacenarán las imágenes
        $directorio_destino = 'ruta/del/directorio';

        // Generar un nombre único para la imagen
        $nombre_imagen = uniqid('img_') . '_' . time() . '.' . pathinfo($imagen['name'], PATHINFO_EXTENSION);

        // Ruta completa de destino para la imagen
        $ruta_completa = $directorio_destino . '/' . $nombre_imagen;

        // Mover la imagen al directorio de destino
        if (move_uploaded_file($imagen['tmp_name'], $ruta_completa)) {
            // Retornar la ruta completa de la imagen para almacenar en la base de datos
            return $ruta_completa;
        } else {
            // Manejo de errores si no se pudo mover la imagen
            return null; // o puedes lanzar una excepción según tu manejo de errores
        }
    }

    public function showProducto($id_producto){
        require_once('modelo/Producto.php');
        $modelo = new ModeloProducto();

        return $modelo->showProducto($id_producto);
    }

    public function eliminarProducto($id_producto){
        return ($this->modelo->eliminarProducto($id_producto)) ? header("Location: alertas/AlertasProducto/alertasEliminar.php") : header("Location: alertas/AlertasProducto/alertasEliminar.php?id_producto=".$id_producto);
    }
}
?>