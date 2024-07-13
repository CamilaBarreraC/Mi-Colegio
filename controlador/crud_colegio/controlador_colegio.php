<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorColegio {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Colegio.php');
        $this->modelo = new ModeloColegio();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarColegio($nombre_de_colegio, $id_comuna, $direccion) {
        $this->modelo->insertarColegio($nombre_de_colegio, $id_comuna, $direccion);
        return ($id_comuna != false) ? header("Location: alertas/AlertasColegio/alertaIngresar.php?id_comuna=".$id_comuna) : header("Location: alertas/AlertasColegio/alertaIngresar.php");        

    }

    public function actualizarColegio($id_colegio, $nombre_de_colegio, $id_comuna, $direccion){
        return ($this->modelo->actualizarColegio($id_colegio, $nombre_de_colegio, $id_comuna, $direccion) != false) ? header("Location: alertas/AlertasColegio/alertaActualizar.php?id_colegio=".$id_colegio) : header("Location: alertas/AlertasColegio/alertaActualizar.php");
    }

    public function showColegio($id_colegio){
        require_once('modelo/Colegio.php');
        $modelo = new ModeloColegio();

        return $modelo->showColegio($id_colegio);
    }

    public function eliminarColegio($id_colegio){
        return ($this->modelo->eliminarColegio($id_colegio)) ? header("Location: alertas/AlertasColegio/alertasEliminar.php") : header("Location: alertas/AlertasColegio/alertasEliminar.php?id_colegio=".$id_colegio);
    }
}
?>