<?php
class ModeloLista1 {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarLista1($nombre_l1, $id_colegio, $id_curso) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO lista_1 (nombre_l1, id_colegio, id_curso) VALUES (:nombre_l1, :id_colegio, :id_curso) ");
        $stmt->bindParam(':nombre_l1', $nombre_l1);
        $stmt->bindParam(':id_colegio', $id_colegio);
        $stmt->bindParam(':id_curso', $id_curso);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showLista1($id_lista_1){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos de la categoria por su ID
        $stmt = $PDO->prepare("SELECT * FROM lista_1 
        JOIN colegio ON lista_1.id_colegio = colegio.id_colegio
        JOIN curso ON lista_1.id_curso = curso.id_curso
        WHERE lista_1.id_lista_1 = :id_lista_1");
        $stmt->bindParam(':id_lista_1', $id_lista_1);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarLista1($nombre_l1, $id_colegio, $id_curso, $id_lista_1){
        $stmt = $this->PDO->prepare("UPDATE lista_1 SET nombre_l1 = :nombre_l1, id_colegio = :id_colegio, id_curso = :id_curso 
        WHERE id_lista_1 = :id_lista_1");
        
        $stmt->bindParam(':nombre_l1', $nombre_l1);
        $stmt->bindParam(':id_colegio', $id_colegio);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':id_lista_1', $id_lista_1);
        
        return ($stmt->execute()) ? $id_lista_1 : false;
    }

    public function eliminarLista1($id_lista_1){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM lista_1 
        WHERE id_lista_1 = :id_lista_1");
        $stmt->bindParam(':id_lista_1', $id_lista_1);

        $stmt2 = $this->PDO->prepare("DELETE FROM l1_productos WHERE id_lista_1 = :id_lista_1");
        $stmt2->bindParam(':id_lista_1', $id_lista_1);

        return ($stmt2->execute() && $stmt->execute()) ? true : false;
    }
}
?>