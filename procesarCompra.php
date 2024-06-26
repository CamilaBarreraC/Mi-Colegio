<?php 

    // TARJETA CON SALDO DE 100.000 PESOS, PARA HACER COMPRA, VALIDANDO LOS DATOS
    // Y MOSTRANDO TODAS LAS ALERTAS 
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

    // ESTO PERMITE QUE SE INGRESE EL DÍA Y LA FECHA ACTUAL AUTOMÁTICAMENTE, ORDENADA 
    // DE AÑO, MES Y DÍA PARA INSERTAR EN SQL
    $fecha_pedido = date("Y-m-d H:i:s");
    
    // VALIDAR DATOS DE LA TARJETA
    if ($nombre === $nombre_tarjeta && $numero === $num_tarjeta && $fecha_exp === $fechaexp_tarjeta && $cvv === $CVV) {
        // Verificar el saldo para mostrar alerta de saldo insuficiente
        if ($saldo >= $precio_total) {

            include("modelo/conexion_bd.php");
            $conn = $conexion;

            // Insertar el pedido en la base de datos
            $sql = "INSERT INTO pedido (precio_total, estado, fecha, id_medio_pago, rut_cliente, rut_cliente_l2, rut_cliente_extras) VALUES ('$precio_total', 'Pendiente', '$fecha_pedido', 1, '$rut_cliente', '$rut_cliente', '$rut_cliente')";
            
            if ($conn->query($sql) === TRUE) {

                // ID del pedido recién ingresado
                $id_pedido = $conn->insert_id;

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
                                        
                            // ENVÍA PARÁMETRO DE CONFIRMACIÓN PARA MOSTRAR ALERTA EN PEDIDOCOMPLETADO
                            // JUNTO CON EL ID PEDIDO PARA MOSTRAR LOS DETALLES
                            header("Location: PedidoCompletado.php?pedido=confirmado&id_pedido=$id_pedido");
                        } else {
                            echo "Error: " . $sqlBorrarExt . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Error: " . $sqlBorrarCarro . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $sqlBorrar . "<br>" . $conn->error;
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