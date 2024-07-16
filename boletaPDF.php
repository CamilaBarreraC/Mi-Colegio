<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include("modelo/conexion_bd.php");

$conn = $conexion;

// Boleta electrónica del pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['boleta_pedido'])) {
    // Crear una nueva instancia de Dompdf
    $dompdf = new Dompdf();

    $id_pedido = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : '';

    // Consultar la información del pedido
    $sql_pedido = "SELECT *
                   FROM pedido 
                   JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago
                   JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
                   JOIN comuna ON cliente.id_comuna = comuna.id_comuna
                   JOIN region ON comuna.id_region = region.id_region
                   WHERE pedido.id_pedido = '$id_pedido'";
    $result_pedido = $conn->query($sql_pedido);

    if ($result_pedido && $result_pedido->num_rows > 0) {
        $pedido = $result_pedido->fetch_assoc();
        $rut_cliente = $pedido['rut_cliente'];

        // Consultar los detalles del pedido (Lista Escolar)
        $sql_lista = "SELECT *
                      FROM detalle_pedido
                      JOIN pedido ON pedido.id_pedido = detalle_pedido.id_pedido
                      JOIN lista_2 ON lista_2.id_lista_2 = detalle_pedido.id_lista_2
                      JOIN l2_productos ON lista_2.id_lista_2 = l2_productos.id_lista_2 
                      JOIN productos ON l2_productos.id_producto = productos.id_producto
                      JOIN categoria ON categoria.id_categoria = productos.id_categoria
                      JOIN curso ON lista_2.id_curso = curso.id_curso
                      JOIN colegio ON curso.id_colegio = colegio.id_colegio
                      JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
                      WHERE pedido.id_pedido = '$id_pedido'";
        $result_lista = $conn->query($sql_lista);

        // Consultar los detalles del pedido (Productos Extra)
        $sql_extras = "SELECT *
                       FROM detalle_pedido
                       JOIN pedido ON pedido.id_pedido = detalle_pedido.id_pedido
                       JOIN productos_extra ON productos_extra.id_extras = detalle_pedido.id_extras
                       JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago 
                       JOIN productos ON productos_extra.id_producto = productos.id_producto
                       JOIN categoria ON productos.id_categoria = categoria.id_categoria
                       WHERE pedido.id_pedido = '$id_pedido'";
        $result_extras = $conn->query($sql_extras);

        // Generar el contenido HTML para la boleta
        $html = '
        <style>
            .container {
                display: flex;
                justify-content: space-between;
            }
            .left {
                width: 45%;
                float: left;
            }
            .right {
                width: 45%;
                float: right;
            }
        </style>
        <h1>Boleta Electrónica</h1>
        <div class="container">
            <div class="left">
                <h2>Información del Cliente</h2>
                <p><strong>RUT:</strong> ' . $pedido['rut_cliente'] . '</p>
                <p><strong>Nombre:</strong> ' . $pedido['nombre_cliente'] . ' ' . $pedido['apellido_cliente'] . '</p>
                <p><strong>Email:</strong> ' . $pedido['email'] . '</p>
                <p><strong>Teléfono:</strong> ' . $pedido['telefono'] . '</p>
                <p><strong>Dirección:</strong> ' . $pedido['direccion'] . '</p>
                <p><strong>Comuna:</strong> ' . $pedido['nombre_comuna'] . '</p>
                <p><strong>Región:</strong> ' . $pedido['nombre_region'] . '</p>
            </div>
            <div class="right">
        
                <h2>Productos - Lista Escolar</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>';
        
        // Detalles del pedido (Lista Escolar)
        if ($result_lista && $result_lista->num_rows > 0) {
            while ($detalle = $result_lista->fetch_assoc()) {
                $html .= '
                    <tr>
                        <td>' . $detalle['nombre_producto'] . '</td>
                        <td>' . $detalle['cantidad'] . '</td>
                        <td>' . $detalle['precio'] . '</td>
                    </tr>';
            }
        } else {
            $html .= '
                    <tr>
                        <td colspan="3">No se encontraron productos de lista escolar.</td>
                    </tr>';
        }
        
        $html .= '
                </table>
        
                <h2>Productos - Extras</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>';
        
        // Detalles del pedido (Productos Extra)
        if ($result_extras && $result_extras->num_rows > 0) {
            while ($detalle = $result_extras->fetch_assoc()) {
                $html .= '
                    <tr>
                        <td>' . $detalle['nombre_producto'] . '</td>
                        <td>' . $detalle['cantidad'] . '</td>
                        <td>' . $detalle['precio'] . '</td>
                    </tr>';
            }
        } else {
            $html .= '
                    <tr>
                        <td colspan="3">No se encontraron productos extras.</td>
                    </tr>';
        }
        
        $html .= '
                </table>
        
                <h3>Total: $' . $pedido['precio_total'] . '</h3>
            </div>
        </div>';
        
        // Cargar el contenido HTML en Dompdf
        $dompdf->loadHtml($html);
        
        // Configurar el tamaño y la orientación del papel
        $dompdf->setPaper('A4', 'portrait');
        
        // Renderizar el PDF
        $dompdf->render();
        
        // Limpiar el buffer de salida
        ob_clean();
        
        // Enviar el PDF al navegador
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="boleta_pedido.pdf"');
        header('Cache-Control: max-age=0');
        
        echo $dompdf->output();
        exit;
    } else {
        echo "No se encontró el pedido.";
        exit;
    }
} else {
    echo "Solicitud no válida.";
}
?>
