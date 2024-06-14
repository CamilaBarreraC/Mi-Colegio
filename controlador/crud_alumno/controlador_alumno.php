<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorAlumno {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Alumno.php');
        $this->modelo = new ModeloAlumno();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarAlumno($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado) {
        $this->modelo->insertarAlumno($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado);
        return ($nombre_alumno != false) ? header("Location: alertas/AlertasAlumno/alertaIngresar.php?nombre_alumno=".$nombre_alumno) : header("Location: alertas/AlertasAlumno/alertaIngresar.php");        

    }

    public function actualizarAlumno($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado, $id_alumno){
        return ($this->modelo->actualizarAlumno($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado, $id_alumno) != false) ? header("Location: alertas/AlertasAlumno/alertaActualizar.php?id_alumno=".$id_alumno) : header("Location: alertas/AlertasAlumno/alertaActualizar.php");
    }

    public function showAlumno($id_alumno){
        require_once('modelo/Alumno.php');
        $modelo = new ModeloAlumno();

        return $modelo->showAlumno($id_alumno);
    }

    public function eliminarAlumno($id_alumno){
        return ($this->modelo->eliminarAlumno($id_alumno)) ? header("Location: alertas/AlertasAlumno/alertasEliminar.php") : header("Location: alertas/AlertasAlumno/alertasEliminar.php?id_alumno=".$id_alumno);
    }
}
?>