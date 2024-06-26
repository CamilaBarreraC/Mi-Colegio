<?php
require_once('controladorPagCliente/controlador_lista2productos/controlador_lista2productos.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productos'])) {
    $controlador = new ControladorLista2Productos();
    $conexion = new mysqli("localhost", "root", "ipchile", "mi_colegio");

    // Obtener los datos del formulario
    $productos = $_POST['productos'];
    $id_curso = $_POST['id_curso'];
    $id_colegio = $_POST['id_colegio'];
    $rut_cliente = $_POST['rut_cliente'];

    // Verificar si la lista ya existe antes de insertar en lista_2
    if ($controlador->existeLista2($rut_cliente, $id_curso, $id_colegio)) {
        // Si la lista ya existe, redireccionar a la página de alerta
        // Para evitar que se ingresen 2 listas iguales
        header("Location: alertasPagCliente/AlertasLista2Productos/alertaIngresar.php?duplicado=true");
        exit();
    } else {
        // Sentencia para insertar en lista_2, heredando el curso y colegio
        $stmtLista2 = $conexion->prepare("INSERT INTO lista_2 (id_curso, id_colegio, rut_cliente) VALUES (?, ?, ?)");

        $stmtCarro = $conexion->prepare("INSERT INTO carro_compras (id_curso, id_colegio, rut_cliente) VALUES (?, ?, ?)");

        $stmtLista2->bind_param("iis", $id_curso, $id_colegio, $rut_cliente);

        $stmtCarro->bind_param("iis", $id_curso, $id_colegio, $rut_cliente);

        if ($stmtLista2->execute() && $stmtCarro->execute()) {
            // ID de la lista_2 recién ingresada
            $id_lista_2 = $conexion->insert_id;
            // ID del carro_compras recién ingresado
            $id_carro = $conexion->insert_id;
            echo "Datos insertados correctamente en lista_2.";
        } else {
            echo "Error al insertar datos en lista_2: " . $stmtLista2->error;
        }

        $stmtLista2->close();
        $stmtCarro->close();
        $conexion->close();

        // Controlador para insertar los productos
        $controlador->insertarLista2Productos($productos, $rut_cliente, $id_curso, $id_colegio, $id_lista_2, $id_carro);
    }
} else {
    echo "No se insertaron los productos.";
}
?>