<?php
class ModeloAlumno {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarAlumno($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO alumno (nombre_alumno, apellido_paterno, id_curso, rut_apoderado) 
        VALUES (:nombre_alumno, :apellido_paterno, :id_curso, :rut_apoderado) ");
        $stmt->bindParam(':nombre_alumno', $nombre_alumno);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':rut_apoderado', $rut_apoderado);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showAlumno($id_alumno){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del colegio por su ID
        $stmt = $PDO->prepare("SELECT * FROM alumno 
        JOIN cliente ON cliente.rut_cliente = alumno.rut_apoderado
        JOIN curso ON curso.id_curso = alumno.id_curso
        JOIN colegio ON curso.id_colegio = colegio.id_colegio 
        JOIN lista_1 ON curso.id_curso = lista_1.id_curso
        JOIN l1_productos ON lista_1.id_lista_1 = l1_productos.id_lista_1
        JOIN productos ON productos.id_producto = l1_productos.id_producto
        WHERE alumno.id_alumno = :id_alumno;");
        $stmt->bindParam(':id_alumno', $id_alumno);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function showAlumno2($id_alumno){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del colegio por su ID
        $stmt = $PDO->prepare("SELECT * FROM alumno 
        JOIN cliente ON cliente.rut_cliente = alumno.rut_apoderado
        JOIN curso ON curso.id_curso = alumno.id_curso
        JOIN colegio ON curso.id_colegio = colegio.id_colegio 
        JOIN lista_1 ON curso.id_curso = lista_1.id_curso
        JOIN l1_productos ON lista_1.id_lista_1 = l1_productos.id_lista_1
        JOIN productos ON productos.id_producto = l1_productos.id_producto
        WHERE alumno.id_alumno = :id_alumno;");
        $stmt->bindParam(':id_alumno', $id_alumno);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Contar el número de filas obtenidas
        $numero_filas = count($resultados);

        // Si no se encontraron resultados, devuelve false en lugar de 'error'
        if ($numero_filas > 0) {
            return $resultados;
        } else {
            // Si no se encontraron resultados, devuelve false
            return false;
        }
    }

    public function actualizarAlumno($nombre_alumno, $apellido_paterno, $id_curso, $rut_apoderado, $id_alumno){
        $stmt = $this->PDO->prepare("UPDATE alumno SET nombre_alumno = :nombre_alumno, 
        apellido_paterno = :apellido_paterno, id_curso = :id_curso, rut_apoderado = :rut_apoderado 
        WHERE id_alumno = :id_alumno");
        
        $stmt->bindParam(':nombre_alumno', $nombre_alumno);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':rut_apoderado', $rut_apoderado);
        $stmt->bindParam(':id_alumno', $id_alumno);
        
        return ($stmt->execute()) ? $id_alumno : false;
    }

    public function eliminarAlumno($id_alumno){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM alumno WHERE id_alumno = :id_alumno");
        $stmt->bindParam(':id_alumno', $id_alumno);
        return ($stmt->execute()) ? true : false;
    }
}
?>