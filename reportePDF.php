<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include("modelo/conexion_bd.php");

$conn = $conexion;

//Reporte Colegio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_colegio'])) {
    // Crear una nueva instancia de Dompdf
    $dompdf = new Dompdf();

    $xcolegio = isset($_POST['xcolegio']) ? $_POST['xcolegio'] : '';
    $xcomuna = isset($_POST['xcomuna']) ? $_POST['xcomuna'] : '';

    $sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
            FROM colegio 
            JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
            JOIN region ON comuna.id_region = region.id_region";

    $conditions = [];
    if (!empty($xcolegio)) {
        $conditions[] = "region.id_region = '$xcolegio'";
    }
    if (!empty($xcomuna)) {
        $conditions[] = "comuna.id_comuna = '$xcomuna'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY nombre_de_colegio";

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

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    ob_clean();

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="reporte_colegios.pdf"');
    header('Cache-Control: max-age=0');

    echo $dompdf->output();
    exit;
} else {
    echo "Solicitud no válida.";
}
//Reporte Listas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_listas'])) {
    $dompdf = new Dompdf();

    $xcolegio = isset($_POST['xcolegio']) ? $_POST['xcolegio'] : '';

    $sql = "SELECT id_lista_1, nombre_l1, lista_1.id_colegio, lista_1.id_curso, nombre_de_colegio, nombre_curso
    FROM lista_1 
    JOIN colegio ON colegio.id_colegio = lista_1.id_colegio
    JOIN curso ON curso.id_curso = lista_1.id_curso";

    $conditions = [];
    if (!empty($xcolegio)) {
        $conditions[] = "colegio.id_colegio = '$xcolegio'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY nombre_l1";

    $html = '
    <h1>Reporte Listas</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nombre Lista</th>
            <th>Curso</th>
            <th>Colegio</th>
        </tr>';

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $html .= '
            <tr>
                <td>' . $data['nombre_l1'] . '</td>
                <td>' . $data['nombre_curso'] . '</td>
                <td>' . $data['nombre_de_colegio'] . '</td>
            </tr>';
        }
    } else {
        echo "No se encontraron datos.";
        exit;
    }

    $html .= '</table>';

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    ob_clean();

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="reporte_listas.pdf"');
    header('Cache-Control: max-age=0');

    echo $dompdf->output();
    exit;
} else {
    echo "Solicitud no válida.";
}
//Reporte Productos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_productos'])) {
    $dompdf = new Dompdf();

    $xcate = isset($_POST['xcate']) ? $_POST['xcate'] : '';

    $sql = "SELECT id_producto, nombre_producto, productos.id_categoria, precio, nombre_categoria, dir
    FROM productos 
    JOIN categoria ON categoria.id_categoria = productos.id_categoria";

    $conditions = [];
    if (!empty($xcate)) {
        $conditions[] = "productos.id_categoria = '$xcate'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY nombre_producto";

    $html = '
    <h1>Reporte Listas</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nombre Producto</th>
            <th>Categoria</th>
            <th>Precio</th>
        </tr>';

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $html .= '
            <tr>
                <td>' . $data['nombre_producto'] . '</td>
                <td>' . $data['nombre_categoria'] . '</td>
                <td>' . $data['precio'] . '</td>
            </tr>';
        }
    } else {
        echo "No se encontraron datos.";
        exit;
    }

    $html .= '</table>';

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    ob_clean();

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="reporte_listas.pdf"');
    header('Cache-Control: max-age=0');

    echo $dompdf->output();
    exit;
} else {
    echo "Solicitud no válida.";
}