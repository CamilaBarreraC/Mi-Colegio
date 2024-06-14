<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombreColegio = $_POST['nombre_de_colegio'];
    $idComuna = $_POST['id_comuna'];
    $direccion = $_POST['direccion'];

    // Convertir el nombre del colegio a mayúsculas
    $nombreMayus = strtoupper($nombreColegio);
    $direccionMayus = strtoupper($direccion);

    require_once ('controlador/crud_colegio/controlador_colegio.php');
    $obj = new ControladorColegio();

    // Insertar el colegio en la base de datos
    $obj->insertarColegio($nombreMayus, $idComuna, $direccionMayus);
}
?>