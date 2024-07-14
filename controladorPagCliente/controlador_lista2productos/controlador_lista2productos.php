<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php


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

    // Función para verificar si ya ingresó el producto en carro_productos o carro_productos_extra
    public function existeProductoEnCarro($rut_cliente, $id_producto) {
        // Preparar la consulta SQL para verificar si el producto ya existe en carro_productos
        $stmt1 = $this->PDO->prepare("SELECT COUNT(*) AS count FROM carro_productos WHERE id_producto = :id_producto AND id_carro IN (SELECT id_carro FROM carro_compras WHERE rut_cliente = :rut_cliente)");
        $stmt1->bindParam(':id_producto', $id_producto);
        $stmt1->bindParam(':rut_cliente', $rut_cliente);
        $stmt1->execute();
        $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        // Preparar la consulta SQL para verificar si el producto ya existe en carro_productos_extra
        $stmt2 = $this->PDO->prepare("SELECT COUNT(*) AS count FROM carro_productos_extra WHERE id_producto = :id_producto AND rut_cliente = :rut_cliente");
        $stmt2->bindParam(':id_producto', $id_producto);
        $stmt2->bindParam(':rut_cliente', $rut_cliente);
        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        // Verificar si el resultado es mayor que cero en cualquiera de las dos tablas
        return ($result1['count'] > 0 || $result2['count'] > 0);
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

    public function eliminarLista2Productos2($id_producto){
        return ($this->modelo->eliminarLista2Productos2($id_producto)) ? header("Location: alertasPagCliente/AlertasLista2Productos/alertasEliminar.php") : header("Location: alertasPagCliente/AlertasLista2Productos/alertasEliminar.php?id_producto=".$id_producto);
    }
}
?>
