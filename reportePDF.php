<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include("modelo/conexion_bd.php");

// Utilizar la variable de conexión establecida en conexion_bd.php
$conn = $conexion;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_colegio'])) {
    // Crear una nueva instancia de Dompdf
    $dompdf = new Dompdf();

    // Definir el contenido HTML del reporte
    $html = '
    <h1>Reporte de Colegios</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>ID Comuna</th>
            <th>Direccion</th>
            <th>Comuna</th>
            <th>Region</th>
        </tr>';

    $sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
            FROM colegio 
            JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
            JOIN region ON comuna.id_region = region.id_region;";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $html .= '
            <tr>
                <td>' . $data['id_colegio'] . '</td>
                <td>' . $data['nombre_de_colegio'] . '</td>
                <td>' . $data['id_comuna'] . '</td>
                <td>' . $data['direccion'] . '</td>
                <td>' . $data['nombre_comuna'] . '</td>
                <td>' . $data['nombre_region'] . '</td>
            </tr>';
        }
    } else {
        echo "No se encontraron datos.";
        exit;
    }

    $html .= '</table>';

    // Cargar el contenido HTML en Dompdf
    $dompdf->loadHtml($html);

    // (Opcional) Configurar el tamaño y la orientación del papel
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el HTML como PDF
    $dompdf->render();

    // Limpiar el buffer de salida antes de enviar el PDF al navegador
    ob_clean();

    // Establecer los encabezados para la descarga del archivo
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="reporte_colegios.pdf"');
    header('Cache-Control: max-age=0');

    // Enviar el PDF generado al navegador
    echo $dompdf->output();
    exit;
} else {
    echo "Solicitud no válida.";
}
