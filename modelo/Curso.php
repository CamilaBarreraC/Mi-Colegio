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

        $stmt2 = $this->PDO->prepare("DELETE FROM lista_1 WHERE id_curso = :id_curso");
        $stmt2->bindParam(':id_curso', $id_curso);

        $stmt3 = $this->PDO->prepare("DELETE FROM l1_productos WHERE id_lista_1 IN (SELECT id_lista_1 FROM lista_1 WHERE id_curso = :id_curso)");
        $stmt3->bindParam(':id_curso', $id_curso);

        $stmt4 = $this->PDO->prepare("DELETE FROM alumno WHERE id_curso = :id_curso");
        $stmt4->bindParam(':id_curso', $id_curso);

        $stmt5 = $this->PDO->prepare("DELETE FROM lista_2 WHERE id_curso = :id_curso");
        $stmt5->bindParam(':id_curso', $id_curso);

        $stmt6 = $this->PDO->prepare("DELETE FROM detalle_pedido WHERE id_lista_2 IN (SELECT id_lista_2 FROM lista_2 WHERE id_curso = :id_curso)");
        $stmt6->bindParam(':id_curso', $id_curso);

        $stmt7 = $this->PDO->prepare("DELETE FROM l2_productos WHERE id_lista_2 IN (SELECT id_lista_2 FROM lista_2 WHERE id_curso = :id_curso)");
        $stmt7->bindParam(':id_curso', $id_curso);

        return ($stmt7->execute() && $stmt6->execute() && $stmt5->execute() && $stmt4->execute() && $stmt3->execute() && $stmt2->execute() && $stmt->execute()) ? true : false;
    }
}
?>