<?php

require 'conexion.php';

$idColegio = $mysqli->real_escape_string($_POST['id_colegio']);

$sql = $mysqli->query("SELECT id_curso, nombre_curso FROM curso WHERE id_colegio=$idColegio");

$respuesta = "<option value=''>Seleccionar</option>";

while ($row = $sql->fetch_assoc()) {
    $respuesta .= "<option value='" . $row['id_curso'] . "'>" . $row['nombre_curso'] . "</option>";
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
