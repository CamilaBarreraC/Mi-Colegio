<?php
// ARCHIVO PARA ACTUALIZAR LAS CANTIDADES Y ENVIARLAS A LA PÁGINA DE CHECKOUT

include("modelo/conexion_bd.php");

session_start(); // Asegúrate de tener esto para usar sesiones

$conn = $conexion;

$productosSinStockLista2 = array();
$productosSinStockExtras = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cantidades']) && is_array($_POST['cantidades'])) {
        foreach ($_POST['cantidades'] as $id_producto => $cantidad) {
            // Consultar el stock disponible
            $stmtStock = $conn->prepare("SELECT nombre_producto, stock, dir FROM productos WHERE id_producto = ?");
            $stmtStock->bind_param("i", $id_producto);
            $stmtStock->execute();
            $stmtStock->bind_result($nombre_producto, $stock, $dir);
            $stmtStock->fetch();
            $stmtStock->close();

            // Verificar si la cantidad solicitada excede el stock disponible
            if ($cantidad > $stock) {
                $productosSinStockLista2[] = array("id_producto" => $id_producto, "nombre" => $nombre_producto, "cantidad" => $cantidad, "stock" => $stock, "dir" => $dir);
                continue;
            }

            // Actualizar la cantidad del producto en la base de datos
            $stmt = $conn->prepare("UPDATE l2_productos SET cantidad = ? WHERE id_producto = ?");
            $stmt->bind_param("ii", $cantidad, $id_producto);
            $stmt->execute();
            $stmt->close();

            // Actualizar la cantidad del producto del carro de compras
            $stmt2 = $conn->prepare("UPDATE carro_productos SET cantidad = ? WHERE id_producto = ?");
            $stmt2->bind_param("ii", $cantidad, $id_producto);
            $stmt2->execute();
            $stmt2->close();
        }
    }

    if (isset($_POST['cantidades_extras']) && is_array($_POST['cantidades_extras'])) {
        foreach ($_POST['cantidades_extras'] as $id_producto => $cantidad) {
            // Consultar el stock disponible
            $stmtStock = $conn->prepare("SELECT nombre_producto, stock, dir FROM productos WHERE id_producto = ?");
            $stmtStock->bind_param("i", $id_producto);
            $stmtStock->execute();
            $stmtStock->bind_result($nombre_producto, $stock, $dir);
            $stmtStock->fetch();
            $stmtStock->close();

            // Verificar si la cantidad solicitada excede el stock disponible
            if ($cantidad > $stock) {
                $productosSinStockExtras[] = array("id_producto" => $id_producto, "nombre" => $nombre_producto, "cantidad" => $cantidad, "stock" => $stock, "dir" => $dir);
                continue;
            }

            // Actualizar la cantidad del producto extra en la base de datos
            $stmt = $conn->prepare("UPDATE productos_extra SET cantidad = ? WHERE id_producto = ?");
            $stmt->bind_param("ii", $cantidad, $id_producto);
            $stmt->execute();
            $stmt->close();

            // Actualizar la cantidad del producto extra del carro de compras
            $stmt2 = $conn->prepare("UPDATE carro_productos_extra SET cantidad = ? WHERE id_producto = ?");
            $stmt2->bind_param("ii", $cantidad, $id_producto);
            $stmt2->execute();
            $stmt2->close();
        }
    }

    // Guardar productos sin stock en la sesión
    $_SESSION['productosSinStockLista2'] = $productosSinStockLista2;
    $_SESSION['productosSinStockExtras'] = $productosSinStockExtras;

    if (empty($_SESSION['productosSinStockLista2']) && empty($_SESSION['productosSinStockExtras'])) {
        header("Location: CheckoutCompra.php");
    } else {
        header("Location: DetallesCarro.php?stock=SinStock");
    }
    exit();
}
?>
