<?php
class ModeloCliente {
    private $PDO;

    public function __construct() {
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertar($rut_cliente, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $rol, $id_comuna, $clave) {
        // Ejecutar la consulta de inserción en la base de datos
        $stmt = $this->PDO->prepare("INSERT INTO cliente (rut_cliente, nombre_cliente, apellido_cliente, email, telefono, direccion, parentesco, rol, id_comuna, clave) VALUES (:rut_cliente, :nombre_cliente, :apellido_cliente, :email, :telefono, :direccion, :parentesco, :rol, :id_comuna, :clave) ");
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt->bindParam(':apellido_cliente', $apellido_cliente);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':parentesco', $parentesco);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id_comuna', $id_comuna);
        $stmt->bindParam(':clave', $clave);
        
        return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function show($rut_cliente){
        require_once('modelo/db.php');
        $con = new db();
        $PDO = $con->conexion();

        // Consulta SQL para obtener los datos del usuario por su RUT
        $stmt = $PDO->prepare("SELECT * FROM cliente JOIN comuna ON cliente.id_comuna = comuna.id_comuna WHERE rut_cliente = :rut_cliente");
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($rut_cliente, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $id_comuna, $clave){
        $stmt = $this->PDO->prepare("UPDATE cliente SET nombre_cliente = :nombre_cliente, apellido_cliente = :apellido_cliente, email = :email, telefono = :telefono, direccion = :direccion, parentesco = :parentesco, id_comuna = :id_comuna, clave = :clave WHERE rut_cliente = :rut_cliente");
        
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt->bindParam(':apellido_cliente', $apellido_cliente);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':parentesco', $parentesco);
        $stmt->bindParam(':id_comuna', $id_comuna);
        $stmt->bindParam(':clave', $clave);
        
        return ($stmt->execute()) ? $rut_cliente : false;
    }

    public function eliminar($rut_cliente){
        // LLAVES FORÁNEAS
        // Se borró cada tabla que tuviera relación con otra, 
        // Sucede por haber creado un pedido asociado al cliente
        // Se borra el pedido asociado y luego el usuario
        // insert into pedido (precio_total, estado, id_medio_pago, rut_cliente, id_lista_2) values('15000', 'Pendiente', 1, 1234, 1);

        $stmt3 = $this->PDO->prepare("DELETE FROM pedido WHERE rut_cliente = :rut_cliente");
        $stmt3->bindParam(':rut_cliente', $rut_cliente);
        $stmt3->execute();

        $stmt = $this->PDO->prepare("DELETE FROM cliente WHERE cliente.rut_cliente = :rut_cliente");
        $stmt->bindParam(':rut_cliente', $rut_cliente);

        $stmt2 = $this->PDO->prepare("DELETE FROM lista_2 WHERE rut_cliente = :rut_cliente");
        $stmt2->bindParam(':rut_cliente', $rut_cliente);
        $stmt2->execute();


        return ($stmt2->execute() && $stmt->execute()) ? true : false;
    }
}
?>