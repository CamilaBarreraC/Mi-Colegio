<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("modelo/conexion_bd.php");
$conn = $conexion;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reporte_colegio'])) {

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'ID Comuna');
    $sheet->setCellValue('D1', 'Direccion');
    $sheet->setCellValue('E1', 'Comuna');
    $sheet->setCellValue('F1', 'Region');

    $sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
            FROM colegio 
            JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
            JOIN region ON comuna.id_region = region.id_region;";
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
