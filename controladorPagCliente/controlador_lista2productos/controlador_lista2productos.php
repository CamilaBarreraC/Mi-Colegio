<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

session_start();

class ControladorLista2Productos {
    private $modelo;
    private $PDO;

    public function __construct() {
        require_once('modelo/Lista2Productos.php');
        $this->modelo = new ModeloLista2Productos();
        // Inicializar la conexión PDO
        require_once('modelo/db.php');
        $con = new db();
        $this->PDO = $con -> conexion();
    }

    public function insertarLista2Productos($productos, $rut_cliente, $id_curso, $id_colegio, $id_lista_2, $id_carro) {
        if ($this->existeLista($rut_cliente, $id_curso, $id_colegio)) {
            // Si es duplicado, redirecciona a la página de alertas con error
            header("Location: alertasPagCliente/AlertasLista2Productos/alertaIngresar.php?duplicado=true");
            exit(); // Detener el proceso
        } else {
            foreach ($productos as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad = $producto['cantidad'];
                $estado = $producto['estado'];
                $rut_cliente = $producto['rut_cliente'];
    
                $id_lista2_producto = $this->modelo->insertarLista2Productos($id_producto, $cantidad, $estado, $rut_cliente, $id_lista_2, $id_carro);

            }
    
            header("Location: alertasPagCliente/AlertasLista2Productos/alertaIngresar.php?id_producto=".$id_producto);
            exit();
        }
    }

    // Función para verificar si ya ingresó la lista al carrito
    public function existeLista($rut_cliente, $id_curso, $id_colegio) {
        // Preparar la consulta SQL para verificar si el curso y el colegio ya existen
        $stmt = $this->PDO->prepare("SELECT COUNT(*) AS count FROM lista_2 WHERE rut_cliente = :rut_cliente AND id_curso = :id_curso AND id_colegio = :id_colegio");
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':id_colegio', $id_colegio);
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el resultado es mayor que cero (si existe un curso y colegio con los mismos ID)
        return ($result['count'] > 1);
    }

    // Función para verificar si ya ingresó la lista al carrito
    public function existeLista2($rut_cliente, $id_curso, $id_colegio) {
        // Preparar la consulta SQL para verificar si el curso y el colegio ya existen
        $stmt = $this->PDO->prepare("SELECT COUNT(*) AS count FROM lista_2 WHERE rut_cliente = :rut_cliente AND id_curso = :id_curso AND id_colegio = :id_colegio");
        $stmt->bindParam(':rut_cliente', $rut_cliente);
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':id_colegio', $id_colegio);
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el resultado es mayor que cero (si existe un curso y colegio con los mismos ID)
        return ($result['count'] > 0);
    }

    public function actualizarLista2Productos($id_producto, $cantidad, $estado, $concepto, $rut_cliente, $id_lista_2_productos){
        return ($this->modelo->actualizarLista2Productos($id_producto, $cantidad, $estado, $concepto, $rut_cliente, $id_lista_2_productos) != false) ? header("Location: alertasPagCliente/AlertasLista2Productos/alertaActualizar.php?id_lista_2_productos=".$id_lista_2_productos) : header("Location: alertasPagCliente/AlertasLista2Productos/alertaActualizar.php");
    }

    public function showLista2Productos($id_lista_2_productos){
        require_once('modelo/Lista2Productos.php');
        $modelo = new ModeloLista2Productos();

        return $modelo->showLista2Productos($id_lista_2_productos);
    }

    public function eliminarLista2Productos($id_producto){
        return ($this->modelo->eliminarLista2Productos($id_producto)) ? header("Location: alertasPagCliente/AlertasLista2Productos/alertasEliminar.php") : header("Location: alertasPagCliente/AlertasLista2Productos/alertasEliminar.php?id_producto=".$id_producto);
    }
}
?>