<?php 
session_start(); // Iniciar la sesión para acceder a los arrays de la sesión

// TARJETA CON SALDO DE 400.000 PESOS, PARA HACER COMPRA, VALIDANDO LOS DATOS Y MOSTRANDO TODAS LAS ALERTAS
$nombre_tarjeta = "Camila Barrera";
$num_tarjeta = "1234 5678 8083 8083";
$fechaexp_tarjeta = "11/31";
$CVV = "123";
$saldo = 400000;

// INPUTS DEL CHECKOUT
$nombre = $_POST['nombre'];
$numero = $_POST['numero'];
$fecha_exp = $_POST['fecha_exp'];
$cvv = $_POST['cvv'];
$precio_total = $_POST['precio_total'];
$rut_cliente = $_POST['rut_cliente'];

// ESTO PERMITE QUE SE INGRESE EL DÍA Y LA FECHA ACTUAL AUTOMÁTICAMENTE, ORDENADA DE AÑO, MES Y DÍA PARA INSERTAR EN SQL
$fecha_pedido = date("Y-m-d H:i:s");

// VALIDAR DATOS DE LA TARJETA
if ($nombre === $nombre_tarjeta && $numero === $num_tarjeta && $fecha_exp === $fechaexp_tarjeta && $cvv === $CVV) {
    // Verificar el saldo para mostrar alerta de saldo insuficiente
    if ($saldo >= $precio_total) {
        include("modelo/conexion_bd.php");
        $conn = $conexion;

        // Insertar el pedido en la base de datos
        $sql = "INSERT INTO pedido (precio_total, estado, fecha, id_medio_pago, rut_cliente) VALUES ('$precio_total', 'Pendiente', '$fecha_pedido', 1, '$rut_cliente')";
        
        if ($conn->query($sql) === TRUE) {
            // ID del pedido recién ingresado
            $id_pedido = $conn->insert_id;

            // Insertar detalles del pedido para cada id_lista_2 en el array de la sesión
            if (isset($_SESSION['lista2_ids'])) {
                foreach ($_SESSION['lista2_ids'] as $id_lista_2) {
                    $sqlDetalle1 = "INSERT INTO detalle_pedido (id_lista_2, id_pedido) VALUES ('$id_lista_2', '$id_pedido')";
                    if (!$conn->query($sqlDetalle1)) {
                        echo "Error: " . $sqlDetalle1 . "<br>" . $conn->error;
                    }
                }
            }

            // Insertar detalles del pedido para cada id_producto_extra en el array de la sesión
            if (isset($_SESSION['producto_extra_ids'])) {
                foreach ($_SESSION['producto_extra_ids'] as $id_extras) {
                    $sqlDetalle2 = "INSERT INTO detalle_pedido (id_extras, id_pedido) VALUES ('$id_extras', '$id_pedido')";
                    if (!$conn->query($sqlDetalle2)) {
                        echo "Error: " . $sqlDetalle2 . "<br>" . $conn->error;
                    }
                }
            }

            // Restar la cantidad de productos extra del stock
            $sqlRestarStockExtras = "UPDATE productos p
                                     JOIN productos_extra pe ON p.id_producto = pe.id_producto
                                     JOIN detalle_pedido dp ON pe.id_extras = dp.id_extras
                                     SET p.stock = p.stock - pe.cantidad
                                     WHERE dp.id_pedido = '$id_pedido'";
            if (!$conn->query($sqlRestarStockExtras)) {
                echo "Error al actualizar el stock de productos extra: " . $conn->error;
            }

            // Restar la cantidad de productos de lista_2 del stock
            $sqlRestarStockL2 = "UPDATE productos p
                                 JOIN l2_productos l2p ON p.id_producto = l2p.id_producto
                                 JOIN detalle_pedido dp ON l2p.id_lista_2 = dp.id_lista_2
                                 SET p.stock = p.stock - l2p.cantidad
                                 WHERE dp.id_pedido = '$id_pedido'";
            if (!$conn->query($sqlRestarStockL2)) {
                echo "Error al actualizar el stock de productos de lista_2: " . $conn->error;
            }

            // Eliminar los productos del carro primero
            $sqlBorrarProductos = "DELETE FROM carro_productos WHERE id_carro IN (SELECT id_carro FROM carro_compras WHERE rut_cliente = ?)";
            $stmtBorrarProductos = $conn->prepare($sqlBorrarProductos);
            $stmtBorrarProductos->bind_param("i", $rut_cliente);

            $sqlBorrarExt = "DELETE FROM carro_productos_extra WHERE rut_cliente = '$rut_cliente'";

            if ($stmtBorrarProductos->execute()) {
                // Luego eliminar el carro
                $sqlBorrarCarro = "DELETE FROM carro_compras WHERE rut_cliente = ?";
                $stmtBorrarCarro = $conn->prepare($sqlBorrarCarro);
                $stmtBorrarCarro->bind_param("i", $rut_cliente);

                if ($stmtBorrarCarro->execute()) {
                    if ($conn->query($sqlBorrarExt) === TRUE) {
                        // Vaciar los arrays en la sesión después de la compra
                        unset($_SESSION['lista2_ids']);
                        unset($_SESSION['producto_extra_ids']);

                        // ENVÍA PARÁMETRO DE CONFIRMACIÓN PARA MOSTRAR ALERTA EN PEDIDOCOMPLETADO
                        // JUNTO CON EL ID PEDIDO PARA MOSTRAR LOS DETALLES
                        header("Location: PedidoCompletado.php?pedido=confirmado&id_pedido=$id_pedido");
                        exit();
                    } else {
                        echo "Error: " . $sqlBorrarExt . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $sqlBorrarCarro . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sqlBorrarProductos . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        
    } else {
        // ALERTA DE RECHAZO POR FONDOS INSUFICIENTES
        header("Location: CheckoutCompra.php?pedido=insuficiente");
    }
} else {
    // ALERTA POR DATOS INCORRECTOS
    header("Location: CheckoutCompra.php?pedido=rechazado");
}
?>
