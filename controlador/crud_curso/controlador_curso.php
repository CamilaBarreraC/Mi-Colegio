<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorCurso {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Curso.php');
        $this->modelo = new ModeloCurso();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarCurso($nombre_curso , $cantidad_alumnos , $id_colegio) {
        $this->modelo->insertarCurso($nombre_curso , $cantidad_alumnos , $id_colegio);
        return ($id_colegio != false) ? header("Location: alertas/AlertasCurso/alertaIngresar.php?id_colegio=".$id_colegio) : header("Location: alertas/AlertasCurso/alertaIngresar.php");        

    }

    public function actualizarCurso($id_curso , $nombre_curso , $cantidad_alumnos , $id_colegio){
        return ($this->modelo->actualizarCurso($id_curso , $nombre_curso , $cantidad_alumnos , $id_colegio) != false) ? header("Location: alertas/AlertasCurso/alertaActualizar.php?id_curso=".$id_curso) : header("Location: alertas/AlertasCurso/alertaActualizar.php");
    }

    public function showCurso($id_curso){
        require_once('modelo/Curso.php');
        $modelo = new ModeloCurso();

        return $modelo->showCurso($id_curso);
    }

    public function eliminarCurso($id_curso){
        return ($this->modelo->eliminarCurso($id_curso)) ? header("Location: alertas/AlertasCurso/alertasEliminar.php") : header("Location: alertas/AlertasCurso/alertasEliminar.php?id_curso=".$id_curso);
    }
}
?>