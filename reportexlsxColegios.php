<?php

include("modelo/conexion_bd.php");
$conn = $conexion;

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
        FROM colegio 
        JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
        JOIN region ON comuna.id_region = region.id_region;";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Recorrer resultados y almacenar en un array
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row['nombre_de_colegio'], $row['nombre_comuna'], $row['nombre_region']];
    }
} else {
    echo "No se encontraron resultados";
}

// Liberar el resultado
$result->free();

// Crear una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();

// Configurar metadatos
$spreadsheet->getProperties()
    ->setCreator('Nombre del Creador')
    ->setLastModifiedBy('Nombre del Creador')
    ->setTitle('Título del Reporte')
    ->setSubject('Asunto del Reporte')
    ->setDescription('Descripción del Reporte')
    ->setKeywords('reporte, excel, php')
    ->setCategory('Categoria del Reporte');

// Agregar datos al archivo Excel
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'nombre_de_colegio');
$sheet->setCellValue('B1', 'nombre_comuna');
$sheet->setCellValue('C1', 'nombre_region');

// Escribir datos desde el array obtenido de la base de datos
$row = 2;
foreach ($data as $row_data) {
    $sheet->setCellValue('A' . $row, $row_data[0]);
    $sheet->setCellValue('B' . $row, $row_data[1]);
    $sheet->setCellValue('C' . $row, $row_data[2]);
    $row++;
}

// Nombre del archivo de salida
$filename = 'reporte.xlsx';

// Configurar encabezados para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Crear un Writer para Excel (Xlsx)
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Cerrar la conexión a la base de datos
$conn->close();