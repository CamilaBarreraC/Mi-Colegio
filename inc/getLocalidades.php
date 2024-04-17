<?php

/**
 * Script para obtener una lista de localidades asociados a un municipio.
 * Este script es accedido mediante una petición AJAX y devuelve opciones
 * de localidades basadas en el municipio seleccionado por el usuario.
 *
 * @link https://github.com/mroblesdev
 * @author mroblesdev
 */

require 'conexion.php';

$idComuna = $mysqli->real_escape_string($_POST['id_comuna']);

$sql = $mysqli->query("SELECT id_colegio, nombre_de_colegio FROM colegio WHERE id_comuna=$idComuna");

$respuesta = "<option value=''>Seleccionar</option>";

while ($row = $sql->fetch_assoc()) {
    $respuesta .= "<option value='" . $row['id_colegio'] . "'>" . $row['nombre_de_colegio'] . "</option>";
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
