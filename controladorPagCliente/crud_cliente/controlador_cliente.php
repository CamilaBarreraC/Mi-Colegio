<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

class ControladorCliente {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Cliente.php');
        $this->modelo = new ModeloCliente();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarCliente($rut_cliente, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $rol, $id_comuna, $clave) {
        // Verificar si el rut_cliente está duplicado
        if ($this->existeCliente($rut_cliente)) {
            // Rut duplicado, redireccionar a la página de alertas
            header("Location: alertasPagCliente/AlertasCliente/alertas.php?duplicado=true");
            exit(); // Detener el proceso
        }else{
            // Si no hay duplicados, procede con la inserción del cliente
            $rut_cliente = $this->modelo->insertar($rut_cliente, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $rol, $id_comuna, $clave);
            return ($rut_cliente != false) ? header("Location: alertasPagCliente/AlertasCliente/alertas.php?rut_cliente=".$rut_cliente) : header("Location: alertasPagCliente/AlertasCliente/alertas.php");        
        } 
    }

    // Función para verificar si el rut_cliente está duplicado
    private function existeCliente($rut_cliente) {
        // Preparar la consulta SQL para verificar si el rut_cliente ya existe
        $stmt = $this->PDO->prepare("SELECT COUNT(*) AS count FROM cliente WHERE rut_cliente = :rut_cliente");
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el resultado es mayor que cero (si existe un cliente con el mismo rut_cliente)
        return ($result['count'] > 0);
    }

    public function actualizar($rut_cliente, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $id_comuna, $clave){
        return ($this->modelo->actualizar($rut_cliente, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $id_comuna, $clave) != false) ? header("Location:alertasPagCliente/AlertasCliente/alertasActualizar.php?rut_cliente=".$rut_cliente) : header("Location:alertasPagCliente/AlertasCliente/alertasActualizar.php");
    }

    public function show($rut_cliente){
        require_once('modelo/Cliente.php');
        $modelo = new ModeloCliente();

        return $modelo->show($rut_cliente);
    }

    public function eliminar($rut_cliente){
        return ($this->modelo->eliminar($rut_cliente)) ? header("Location:alertasPagCliente/AlertasCliente/alertasEliminar.php") : header("Location:alertasPagCliente/AlertasCliente/alertasEliminar.php?rut_cliente=".$rut_cliente);
    }
}
?>