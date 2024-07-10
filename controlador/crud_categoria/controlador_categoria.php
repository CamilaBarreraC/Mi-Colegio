<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorCategoria {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Categoria.php');
        $this->modelo = new ModeloCategoria();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarCategoria($nombre_categoria) {
        if ($this->modelo->categoriaExiste($nombre_categoria)) {
            // Redirige con "duplicado" en la URL
            header("Location: Categorias.php?duplicado=true");
        } else {
            $this->modelo->insertarCategoria($nombre_categoria);
            header("Location: alertas/AlertasCategoria/alertaIngresar.php?nombre_categoria=".$nombre_categoria);
        }
    }

    public function actualizarCategoria($id_categoria , $nombre_categoria){
        return ($this->modelo->actualizarCategoria($id_categoria , $nombre_categoria) != false) ? header("Location: alertas/AlertasCategoria/alertaActualizar.php?id_categoria=".$id_categoria) : header("Location: alertas/AlertasCategoria/alertaActualizar.php");
    }

    public function showCategoria($id_categoria){
        require_once('modelo/Categoria.php');
        $modelo = new ModeloCategoria();

        return $modelo->showCategoria($id_categoria);
    }

    public function eliminarCategoria($id_categoria){
        return ($this->modelo->eliminarCategoria($id_categoria)) ? header("Location: alertas/AlertasCategoria/alertasEliminar.php") : header("Location: alertas/AlertasCategoria/alertasEliminar.php?id_categoria=".$id_categoria);
    }
}
?>