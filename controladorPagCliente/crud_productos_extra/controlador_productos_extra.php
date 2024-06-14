<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorProductoExtra {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/ProductoExtra.php');
        $this->modelo = new ModeloProductoExtra();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarProductoExtra($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado) {
        $this->modelo->insertarProductoExtra($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado);
        return ($nombre_alumno != false) ? header("Location: alertasPagCliente/AlertasAlumno/alertaIngresar.php?nombre_alumno=".$nombre_alumno) : header("Location: alertasPagCliente/AlertasAlumno/alertaIngresar.php");        

    }

    public function actualizarProductoExtra($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado, $id_alumno){
        return ($this->modelo->actualizarProductoExtra($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado, $id_alumno) != false) ? header("Location: alertasPagCliente/AlertasAlumno/alertaActualizar.php?id_alumno=".$id_alumno) : header("Location: alertasPagCliente/AlertasAlumno/alertaActualizar.php");
    }

    public function showProductoExtra($id_alumno){
        require_once('modelo/ProductoExtra.php');
        $modelo = new ModeloProductoExtra();

        return $modelo->showProductoExtra($id_alumno);
    }

    public function eliminarProductoExtra($id_alumno){
        return ($this->modelo->eliminarProductoExtra($id_alumno)) ? header("Location: alertasPagCliente/AlertasAlumno/alertasEliminar.php") : header("Location: alertasPagCliente/AlertasAlumno/alertasEliminar.php?id_alumno=".$id_alumno);
    }
}
?>