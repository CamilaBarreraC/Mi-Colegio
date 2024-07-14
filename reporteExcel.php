<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("modelo/conexion_bd.php");
$conn = $conexion;

//Reporte colegios
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_colegio'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'ID Comuna');
    $sheet->setCellValue('D1', 'Direccion');
    $sheet->setCellValue('E1', 'Comuna');
    $sheet->setCellValue('F1', 'Region');

    // Obtén los filtros del formulario
    $xcolegio = isset($_POST['xcolegio']) ? $_POST['xcolegio'] : '';
    $xcomuna = isset($_POST['xcomuna']) ? $_POST['xcomuna'] : '';

    // Construye la consulta SQL usando los filtros
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

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = 2;
        while ($data = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $data['id_colegio']);
            $sheet->setCellValue('B' . $row, $data['nombre_de_colegio']);
            $sheet->setCellValue('C' . $row, $data['id_comuna']);
            $sheet->setCellValue('D' . $row, $data['direccion']);
            $sheet->setCellValue('E' . $row, $data['nombre_comuna']);
            $sheet->setCellValue('F' . $row, $data['nombre_region']);
            $row++;
        }
    } else {
        echo "No se encontraron datos.";
        exit;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reporte_colegios.xlsx"');
    header('Cache-Control: max-age=0');

    // Limpiar el buffer de salida antes de generar el archivo Excel
    ob_end_clean();

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "Solicitud no válida.";
}
//Reporte Listas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_listas'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Nombre Lista');
    $sheet->setCellValue('B1', 'Curso');
    $sheet->setCellValue('C1', 'Colegio');

    // Obtén los filtros del formulario
    $xcolegio = isset($_POST['xcolegio']) ? $_POST['xcolegio'] : '';

    // Construye la consulta SQL usando los filtros
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

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = 2;
        while ($data = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $data['nombre_l1']);
            $sheet->setCellValue('B' . $row, $data['nombre_curso']);
            $sheet->setCellValue('C' . $row, $data['nombre_de_colegio']);
            $row++;
        }
    } else {
        echo "No se encontraron datos.";
        exit;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reporte_listas.xlsx"');
    header('Cache-Control: max-age=0');

    // Limpiar el buffer de salida antes de generar el archivo Excel
    ob_end_clean();

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "Solicitud no válida.";
}

//Reporte Listas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_productos'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Nombre producto');
    $sheet->setCellValue('B1', 'Categoria');
    $sheet->setCellValue('C1', 'Precio');

    // Obtén los filtros del formulario
    $xcate = isset($_POST['xcate']) ? $_POST['xcate'] : '';

    // Construye la consulta SQL usando los filtros
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

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = 2;
        while ($data = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $data['nombre_producto']);
            $sheet->setCellValue('B' . $row, $data['nombre_categoria']);
            $sheet->setCellValue('C' . $row, $data['precio']);
            $row++;
        }
    } else {
        echo "No se encontraron datos.";
        exit;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reporte_producto.xlsx"');
    header('Cache-Control: max-age=0');

    // Limpiar el buffer de salida antes de generar el archivo Excel
    ob_end_clean();

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "Solicitud no válida.";
}