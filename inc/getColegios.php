<?php

require 'conexion.php';

$idComuna = $mysqli->real_escape_string($_POST['id_comuna']);

$sql = $mysqli->query("SELECT id_colegio, nombre_de_colegio FROM colegio WHERE id_comuna=$idComuna");

$respuesta = "<option value=''>Seleccionar</option>";

while ($row = $sql->fetch_assoc()) {
    $respuesta .= "<option value='" . $row['id_colegio'] . "'>" . $row['nombre_de_colegio'] . "</option>";
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
