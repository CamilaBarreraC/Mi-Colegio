<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorLista1 {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Lista1.php');
        $this->modelo = new ModeloLista1();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarLista1($nombre_l1, $id_colegio, $id_curso) {
        $this->modelo->insertarLista1($nombre_l1, $id_colegio, $id_curso);
        return ($nombre_l1 != false) ? header("Location: alertas/AlertasLista1/alertaIngresar.php?nombre_l1=".$nombre_l1) : header("Location: alertas/AlertasLista1/alertaIngresar.php");        

    }

    public function actualizarLista1($nombre_l1, $id_colegio, $id_curso, $id_lista_1){
        return ($this->modelo->actualizarLista1($nombre_l1, $id_colegio, $id_curso, $id_lista_1) != false) ? header("Location: alertas/AlertasLista1/alertaActualizar.php?id_lista_1=".$id_lista_1) : header("Location: alertas/AlertasLista1/alertaActualizar.php");
    }

    public function showLista1($id_lista_1){
        require_once('modelo/Lista1.php');
        $modelo = new ModeloLista1();

        return $modelo->showLista1($id_lista_1);
    }

    public function eliminarLista1($id_lista_1){
        return ($this->modelo->eliminarLista1($id_lista_1)) ? header("Location: alertas/AlertasLista1/alertasEliminar.php") : header("Location: alertas/AlertasLista1/alertasEliminar.php?id_lista_1=".$id_lista_1);
    }
}
?>