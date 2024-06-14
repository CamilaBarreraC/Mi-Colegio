<?php
class ModeloColegio {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarColegio($nombre_de_colegio, $id_comuna, $direccion) {
        // Ejecutar la consulta en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO colegio (nombre_de_colegio, id_comuna, direccion) VALUES (:nombre_de_colegio, :id_comuna, :direccion) ");
        $stmt->bindParam(':nombre_de_colegio', $nombre_de_colegio);
        $stmt->bindParam(':id_comuna', $id_comuna);
        $stmt->bindParam(':direccion', $direccion);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function showColegio($id_colegio){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del colegio por su ID
        $stmt = $PDO->prepare("SELECT * FROM colegio JOIN comuna ON colegio.id_comuna = comuna.id_comuna
        JOIN region ON region.id_region = comuna.id_region WHERE id_colegio = :id_colegio");
        $stmt->bindParam(':id_colegio', $id_colegio);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarColegio($id_colegio, $nombre_de_colegio, $id_comuna, $direccion){
        $stmt = $this->PDO->prepare("UPDATE colegio SET nombre_de_colegio = :nombre_de_colegio, direccion = :direccion, id_comuna = :id_comuna WHERE id_colegio = :id_colegio");
        
        $stmt->bindParam(':id_colegio', $id_colegio);
        $stmt->bindParam(':nombre_de_colegio', $nombre_de_colegio);
        $stmt->bindParam(':id_comuna', $id_comuna);
        $stmt->bindParam(':direccion', $direccion);
        
        return ($stmt->execute()) ? $id_colegio : false;
    }

    public function eliminarColegio($id_colegio){
        // LLAVES FORÁNEAS

        $stmt = $this->PDO->prepare("DELETE FROM colegio WHERE id_colegio = :id_colegio");
        $stmt->bindParam(':id_colegio', $id_colegio);
        return ($stmt->execute()) ? true : false;
    }
}
?>