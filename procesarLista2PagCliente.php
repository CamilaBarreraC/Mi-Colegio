<?php
require_once('controladorPagCliente/controlador_lista2productos/controlador_lista2productos.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productos'])) {
    $controlador = new ControladorLista2Productos();
    $conexion = new mysqli("localhost", "root", "ipchile", "mi_colegio");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener los datos del formulario
    $productos = $_POST['productos'];
    $id_curso = $_POST['id_curso'];
    $id_colegio = $_POST['id_colegio'];
    $rut_cliente = $_POST['rut_cliente'];

    // Verificar si la lista ya existe antes de insertar en lista_2
    if ($controlador->existeLista2($rut_cliente, $id_curso, $id_colegio)) {
        // Si la lista ya existe, redireccionar a la página de alerta
        header("Location: alertasPagCliente/AlertasLista2Productos/alertaIngresar.php?duplicado=true");
        exit();
    } else {
        // Preparar la sentencia para insertar en lista_2
        $stmtLista2 = $conexion->prepare("INSERT INTO lista_2 (id_curso, id_colegio, rut_cliente) VALUES (?, ?, ?)");
        if ($stmtLista2 === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmtLista2->bind_param("iis", $id_curso, $id_colegio, $rut_cliente);
        if ($stmtLista2->execute()) {
            echo "Datos insertados correctamente en lista_2.";
        } else {
            echo "Error al insertar datos en lista_2: " . $stmtLista2->error;
        }

        $stmtLista2->close();
        $conexion->close();

        // Llamar al método del controlador para insertar los productos
        $controlador->insertarLista2Productos($productos, $rut_cliente, $id_curso, $id_colegio);
    }
} else {
    echo "No se recibieron productos.";
}
?>