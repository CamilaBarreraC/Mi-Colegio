<?php

/**
 * Script para obtener una lista de municipios asociados a un estado.
 * Este script es accedido mediante una petición AJAX y devuelve opciones
 * de municipios basadas en el estado seleccionado por el usuario.
 *
 * @link https://github.com/mroblesdev
 * @author mroblesdev
 */

require 'conexion.php';

$idRegion = $mysqli->real_escape_string($_POST['id_region']);

$sql = $mysqli->query("SELECT id_comuna, nombre_comuna FROM comuna WHERE id_region=$idRegion");

$respuesta = "<option value=''>Seleccionar</option>";

while ($row = $sql->fetch_assoc()) {
    $respuesta .= "<option value='" . $row['id_comuna'] . "'>" . $row['nombre_comuna'] . "</option>";
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
