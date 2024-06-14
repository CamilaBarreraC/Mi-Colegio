<?php
class ModeloCurso {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarCurso($nombre_curso , $cantidad_alumnos , $id_colegio ) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO curso (nombre_curso, cantidad_alumnos, id_colegio) VALUES (:nombre_curso, :cantidad_alumnos, :id_colegio) ");
        $stmt->bindParam(':nombre_curso', $nombre_curso);
        $stmt->bindParam(':cantidad_alumnos', $cantidad_alumnos);
        $stmt->bindParam(':id_colegio', $id_colegio);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showCurso($id_curso){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del curso por su ID
        $stmt = $PDO->prepare("SELECT * FROM curso 
        JOIN colegio ON colegio.id_colegio = curso.id_colegio
        WHERE curso.id_curso = :id_curso");
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarCurso($id_curso , $nombre_curso , $cantidad_alumnos , $id_colegio){
        $stmt = $this->PDO->prepare("UPDATE curso SET nombre_curso = :nombre_curso, cantidad_alumnos = :cantidad_alumnos, id_colegio = :id_colegio WHERE id_curso = :id_curso");
        
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':nombre_curso', $nombre_curso);
        $stmt->bindParam(':cantidad_alumnos', $cantidad_alumnos);
        $stmt->bindParam(':id_colegio', $id_colegio);
        
        return ($stmt->execute()) ? $id_curso : false;
    }

    public function eliminarCurso($id_curso){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM curso WHERE id_curso = :id_curso");
        $stmt->bindParam(':id_curso', $id_curso);
        return ($stmt->execute()) ? true : false;
    }
}
?>