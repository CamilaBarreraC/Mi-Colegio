<?php
    // ARCHIVO PARA ACTUALIZAR LAS CANTIDADES Y ENVIARLAS A LA PÁGINA DE CHECKOUT

    include("modelo/conexion_bd.php");

    $conn = $conexion;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cantidades']) && is_array($_POST['cantidades'])) {
            foreach ($_POST['cantidades'] as $id_producto => $cantidad) {
                // Actualizar la cantidad del producto en la base de datos
                $stmt = $conn->prepare("UPDATE l2_productos SET cantidad = ? WHERE id_producto = ?");
                $stmt->bind_param("ii", $cantidad, $id_producto);
                $stmt->execute();
                // Actualizar la cantidad del producto del carro de compras
                $stmt2 = $conn->prepare("UPDATE carro_productos SET cantidad = ? WHERE id_producto = ?");
                $stmt2->bind_param("ii", $cantidad, $id_producto);
                $stmt2->execute();

                $stmt2->close();
                $stmt->close();
            }
        }

        if (isset($_POST['cantidades_extras']) && is_array($_POST['cantidades_extras'])) {
            foreach ($_POST['cantidades_extras'] as $id_producto => $cantidad) {
                // Actualizar la cantidad del producto extra en la base de datos
                $stmt = $conn->prepare("UPDATE productos_extra SET cantidad = ? WHERE id_producto = ?");
                $stmt->bind_param("ii", $cantidad, $id_producto);
                $stmt->execute();
                // Actualizar la cantidad del producto extra en la base de datos
                $stmt2 = $conn->prepare("UPDATE carro_productos_extra SET cantidad = ? WHERE id_producto = ?");
                $stmt2->bind_param("ii", $cantidad, $id_producto);
                $stmt2->execute();

                $stmt2->close();
                $stmt->close();
            }
        }

        // Redirigir a la página de checkout o mostrar un mensaje de éxito
        header("Location: CheckoutCompra.php");
        exit();
    }

?>