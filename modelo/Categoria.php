<?php
class ModeloCategoria {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarCategoria($nombre_categoria) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO categoria (nombre_categoria) VALUES (:nombre_categoria) ");
        $stmt->bindParam(':nombre_categoria', $nombre_categoria);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showCategoria($id_categoria){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos de la categoria por su ID
        $stmt = $PDO->prepare("SELECT * FROM categoria 
        JOIN productos ON categoria.id_categoria = productos.id_categoria
        WHERE categoria.id_categoria = :id_categoria");
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarCategoria($id_categoria , $nombre_categoria){
        $stmt = $this->PDO->prepare("UPDATE categoria SET nombre_categoria = :nombre_categoria WHERE id_categoria = :id_categoria");
        
        $stmt->bindParam(':nombre_categoria', $nombre_categoria);
        $stmt->bindParam(':id_categoria', $id_categoria);
        
        return ($stmt->execute()) ? $id_categoria : false;
    }

    public function eliminarCategoria($id_categoria){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM categoria WHERE id_categoria = :id_categoria");
        $stmt->bindParam(':id_categoria', $id_categoria);

        $stmt2 = $this->PDO->prepare("DELETE FROM productos WHERE id_categoria = :id_categoria");
        $stmt2->bindParam(':id_categoria', $id_categoria);

        return ($stmt2->execute() && $stmt->execute()) ? true : false;
    }
}
?>